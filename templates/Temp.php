
namespace <?=$namespace?>;
<?= ($namespace =='app\models') ? "\r\n" :  'use app\\models\\Model;'."\r\n" ?>
use core\RD; // redis 类
use core\DB; // DB 类

class <?=$fileName?> extends Model {
    // protected $table = '<?=$name?>s';
    // protected $fillable = [];
    function insert($data) {
        
        $data = [
            'key'=>'',
        ];
        
        $data = self::exec_insert($data);
        if ($data) {
            return true;

        }else{
            return false;

        }

    }

    function delete($id) {

        $condition = [
            'id'=>$id,
        ];
        return self::exec_delete($condition);
        
    }

    function update($id,$data){

        $data = [
            'key'=>'',
        ];

        $condition = [
            'id'=>$id,
        ];

        return self::exec_update($data,$condition);
    }



}