<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Traits\UploadFile;
use App\Enums\UserRole;
use App\Jobs\SendEmailJob;

class UserController extends Controller
{
      use UploadFile;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('server.user.add');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $req)
    {
        $temp = $req->except(['_token']);
        $temp['password'] = bcrypt($req->password);
        
        if($req->hasfile('avatar')){
            $image=$req->file('avatar');
            $temp['avatar'] = $this->upload($image);
        }
        $insert = User::create($temp)->toArray();
        dispatch(new SendEmailJob($insert));

        if(isset($insert)){
            return back()->with('msg', __('messages.add.success'));
        }else{
            return back()->with('msg', __('messages.add.fail'));
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->loadUserWithTrash($id);
        return view('server.user.profile',compact('user','id')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $req, $id)
    {
        $user = $this->loadUserWithTrash($id);
        $temp = $req->except(['_token']);
        if($req->password!=null){
            $temp['password'] = bcrypt($req->password);
        }else{
           unset($temp['password']);
        }
        if($req->hasfile('avatar')){
            $image=$req->file('avatar');
            if($user->avatar!=null){
                $img = $user->avatar;
                $path = public_path('upload/' . $img);
                if(file_exists($path)){
                    unlink(public_path('upload/' . $img));
                }
            }
            $image = $req->file('avatar');
            $temp['avatar'] = $this->upload($image);

        }
        $update = $user->update($temp);
        if($update){
            return back()->with('msg', __('messages.update.success'));
        }else{
            return back()->with('fail', __('messages.update.fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->loadUserWithTrash($id);
        if($user->avatar!=null){
            $img = $user->avatar;
            $path = public_path('upload/' . $img);
            if(file_exists($path)){
                unlink(public_path('upload/' . $img));
            }
        }
        $this->checkDataInTransaction($user,__FUNCTION__);
        
    }
    public function softDelete($id){
        $user = $this->loadUserWithTrash($id);
        $this->checkDataInTransaction($user,__FUNCTION__);
    }
    public function restore($id){
        $user = $this->loadUserWithTrash($id);
        $this->checkDataInTransaction($user,__FUNCTION__);
    }

    public function trainee(){
        $users = User::withTrashed()->where('role',UserRole::Trainee)->paginate(5);
        return view('server.user.table',compact('users'));
    }
    public function supervisor(){
        $users = User::withTrashed()->where('role',UserRole::Supervisor)->paginate(5);
        return view('server.user.table',compact('users'));
    }

}
