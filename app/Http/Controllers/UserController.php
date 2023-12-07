<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('students')->role(['siswa','bendahara'])->get();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'                   => 'required',
            'email'                  => 'required',
            'password'               => 'required',
            'phone'                  => 'required',
            'alamat'                 => 'required',
            'kelas'                  => 'required',
            'image'                  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($users = User::create([
            'name'                   =>  $request->input('name'),
            'email'                  =>  $request->input('email'),
            'password'               =>  bcrypt($request->get('password')),
            'email_verified_at'      =>  now(),

        ])){
            $input = $request->all();
            if($image = $request->file('image')){
                $destinationPath = 'images/';

                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

                $image->move($destinationPath, $profileImage);

            }
            $perwalian = Student::create([
                'user_id'       => $users->id,
                'phone'         => $request->input('phone'),
                'alamat'        => $request->input('alamat'),
                'kelas'         => $request->input('kelas'),
                'image'         => "$profileImage",
            ]);
            $request->except('roles');
                $roleId = $request->get('roles');
                $role = Role::findById($roleId);
                $users->assignRole($role->name);
                
        }


        return redirect()->back()->with('flash', 'data siswa berhasil ditabahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('users.edit', compact('user','roles'));
    }
    
        public function update(Request $request, $id)
        {
            $user = User::findOrFail($id);
    
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'kelas' => 'required',
                'alamat' => 'required',
                'phone' => 'required',
                'image' => 'nullable'
               
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            

            foreach ($user->students as $student) {
                $student->kelas = $request->kelas;
                $student->alamat = $request->alamat;
                $student->phone = $request->phone;
                $user->roles()->sync($request->roles);
                $old_image = public_path('images/'. $student->image);
                if(\File::exists($old_image)) {
                    \File::delete($old_image);
                }
                $input = $request->all();
                
                if($image = $request->file('image')){
                    $destinationPath = 'images/';
        
                    $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        
                    $image->move($destinationPath, $profileImage);
        
                    $input['image'] = $profileImage;
                }else{
                    unset($input['image']);
                }
                $user->save();
                $student->save();
                $student->update($input);
            }
    
            return redirect()->route('users')->with('success', 'User updated successfully');
        }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $students = Student::where('user_id', $id)->first();

        if ($students->image) {
            $this->deleteImage($students->image);
        }

        if($students->delete($request->all())){
            $user->delete();
        }

        return redirect()->back();
    }
    public function deleteImage($imageName)
    {
        $path = public_path('images/' . $imageName);

        if (file_exists($path)) {
            unlink($path);
        }
    }

}