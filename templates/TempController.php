
namespace <?=$namespace?>;
<?= ($namespace =='app\controllers') ? "\r\n" :  'use app\\controllers\\Controller;'."\r\n" ?>
use core\Request;
<?= (isset($this->group))? "use ".$this->mspace."\\$fileName;"."\r\n" : "" ?>

class <?=$fileName?>Controller extends Controller {

    // 显示列表
    function index() {

        view('<?=$name?>.index');
    }

    // 显示 添加页
    function add(){

        view('<?=$name?>.create');
    }

    // 添加
    function insert(Request $req,$id) {
    }

    // 删除
    function del(Request $req,$id){
    }
    
    // 显示 修改页
    function mod(){
        
        view('<?=$name?>.edit');
    }

    // 修改
    function update(Request $req,$id) {
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>