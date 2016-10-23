<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /**
     * 全部配置项列表
     */
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        foreach($data as $k=>$value){
            switch($value->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$value->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="textarea"  class="lg" name="conf_content[]">'.$value->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arr = explode(',',$value->field_value);
                    $str = '';
                    foreach($arr as $m=>$val){
                        $arr1 = explode('|',$val);
                        $c = $value->conf_content==$arr1[0]?' checked ':'';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$arr1[0].'" '.$c.'>'.$arr1[1].'　';
                    }
                   $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.config.index',compact('data'));
    }

    /**
     * 添加配置项
     */
    public function create()
    {
        return view('admin.config.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');

        $rules = [
            'conf_name'=>'required',
            'conf_title'=>'required'
        ];
        $message = [
            'conf_name.required'=>'配置项名称不能为空',
            'conf_title.required'=>'配置项标题不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        //判断validator  如果错误返回错误信息
        if($validator->passes()){
            $res = Config::create($input);
            if($res){
                return redirect('admin/config');
            }else{
                return Redirect::back()->with('errors','配置项添加失败,请稍后重试');
            }
        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑配置项
     */
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }

    /**
     * 更新配置项
     */
    public function update(Request $request, $conf_id)
    {
        $input = Input::except('_token','_method');
        $res = Config::where('conf_id',$conf_id)->update($input);
        if($res){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return Redirect::back()->with('errors','配置项信息更新失败,请稍后重试');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($conf_id)
    {
        $res = Config::where('conf_id',$conf_id)->delete();
        if($res){
            $this->putFile();
            $data = [
                'status' => 1,
                'msg'    =>'配置项删除成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'配置项删除失败'
            ];
        }
        return $data;
    }

    public function changeOrder(){
        $input = Input::all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $res = $config->update();
        if($res){
            $data = [
                'status' => 1,
                'msg'    =>'配置项排序更新成功'
            ];
        }else{
            $data = [
                'status' => 0,
                'msg'    =>'配置项排序更新失败'
            ];
        }
        return $data;
    }

    public function changeContent()
    {
        $input = Input::all();
        foreach($input['conf_id'] as $k=>$value){
            Config::where('conf_id',$value)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置项更新成功');
    }

    public function putFile(){
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\myWeb.php';
        $str = "<?php return ".var_export($config,true).';';
        file_put_contents($path,$str);
    }
}
      
