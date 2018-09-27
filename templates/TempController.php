
namespace <?=$namespace?>;
<?= ($namespace =='app\controllers') ? "\r\n" :  'use app\\controllers\\Controller;'."\r\n" ?>
use core\Request;
<?= (isset($this->group))? "use ".$this->mspace."\\$fileName;"."\r\n" : "" ?>

class <?=$fileName?>Controller extends Controller {

    /*
        // 注册 路由
    Route::get('/<?=$name?>/index','app/controllers/<?=$fileName?>Controller@index')->name('<?=$name?>.index'); // 显示列表
    Route::get('/<?=$name?>/search','app/controllers/<?=$fileName?>Controller@search')->name('<?=$name?>.search'); // 搜索

    Route::get('/<?=$name?>/add','app/controllers/<?=$fileName?>Controller@add')->name('<?=$name?>.add'); // 显示 添加
    Route::post('/<?=$name?>/insert','app/controllers/<?=$fileName?>Controller@insert')->name('<?=$name?>.insert'); // 添加

    Route::post('/<?=$name?>/del','app/controllers/<?=$fileName?>Controller@del')->name('<?=$name?>.del'); // 删除

    Route::get('/<?=$name?>/mod','app/controllers/<?=$fileName?>Controller@mod')->name('<?=$name?>.mod'); // 显示 修改
    Route::post('/<?=$name?>/update','app/controllers/<?=$fileName?>Controller@update')->name('<?=$name?>.update'); // 修改

    */

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