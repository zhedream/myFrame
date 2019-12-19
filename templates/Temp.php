
namespace <?=$namespace?>;
<?= ($namespace =='app\Models') ? PHP_EOL :  'use app\\models\\Model;'.PHP_EOL ?>
use core\RD; // redis 类
use core\DB; // DB 类

class <?=$fileName?> extends Model {
    
    protected $table = '<?=$this->table?>';
    protected $fillable = <?=$fillableStr?>;


}