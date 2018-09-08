<?php
class BaseChainObject{
    /**
* 追溯数据，用来进行调试
* @var array
*/
private $_trace_data = array();
    /**
    *    保存可用方法列表
    *    @param array
    */
    protected $_methods = array();
    /**
    *    处理的数据
    *    @param null
    */
    public $data;
    function __construct($data){
        $this->data = $data;
        $this->_trace_data['__construct'] = $data;
        return $this->data;
    }
    function __toString(){
        return (String)$this->data;
    }
    function __call($name,$args){
        try{
            $this->vaild_func($name);
        }catch(Exception $e){
            echo $e->getMessage();
            exit();
        }
        if (!$args) {
            $args = $this->data;
            $this->data = call_user_func($name,$args);
        }else{
            $this->data = call_user_func_array($name,$args);
        }
        $this->_trace_data[$name] = $this->data;
        return $this;
    }
    /**
    *    判断方法是否存在
    *    @param string
    */
    private function vaild_func($fn){
        if(!in_array($fn, $this->_methods)){
            throw new Exception("unvaild method");
        }
    }
    public function trace(){
      var_dump($this->_trace_data);
    }
}
class go extends BaseChainObject{
    protected $_methods = array('trim','strlen');
}
$str = new go('ab rewqc ');
echo $str->trim('123')->strlen('qweqwe');
$str->trace();