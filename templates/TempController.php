
namespace <?=$namespace?>;
<?= ($namespace =='app\controllers') ? "\r\n" :  'use app\\controllers\\Controller;'."\r\n" ?>
use core\Request;
<?= (isset($this->group))? "use ".$this->mspace."\\$fileName;"."\r\n" : "" ?>

class <?=$fileName?>Controller extends Controller {

    // 显示列表
    function index() {
        $<?=$name?> = new <?=$fileName?>;
        $data = $<?=$name?>->get();
        view('<?=$name?>.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('<?=$name?>.create');
    }

    // 添加
    function insert(Request $req,$id) {
        $data = $req->all();
        $<?=$name?> = new <?=$fileName?>;
        $<?=$name?>->exec_insert($data);
        redirect(Route('<?=$name?>.add'));
    }

    // 删除
    function del(Request $req,$id){
    }
    
    // 显示 修改页
    function mod(){
        $<?=$name?> = new <?=$fileName?>;
        $data = $<?=$name?>->where(1)->get();
        view('<?=$name?>.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>