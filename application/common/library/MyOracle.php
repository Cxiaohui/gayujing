<?php
/**
 * Created by PhpStorm.
 * User: xiaohui
 * Date: 2019/2/27
 */
namespace app\common\library;

class MyOracle{


    protected static $instance = null;
    protected static $connection = null;
    protected static $config = [];
    protected $stmt = null;

    protected $blob_decs = [];
    protected $error = '';

    protected function __construct()
    {
        self::$config = config('database.');
        $this->connect();
    }

    public static function instance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function updateWithBlob($table,$data,$returning,$blob_datas,$where){

        try{
            //sql
            $sql1 = $this->getUpdateSqlPart($table,$data,$where);
            $sql2 = $this->getReturnSqlPart($returning);
            $sql = $sql1.' '.$sql2;

            $this->ociParse($sql);

            $this->bolbNewDescs($returning);

            $this->ociExecute();

            $res = $this->blobSave($blob_datas);
            if($res){
                $this->ociCommit();
            }else{
                $this->ociRollback();
            }

            $this->freeBlobDecs();
            $this->ociFreeStatement();
            $this->close();

            return $res;
        }catch (\Exception $e){
            $this->setError($e->getMessage());

            $this->close();
        }
        return false;
    }

    public function insertWithBlob($table,$data,$returning,$blob_datas){

        try{
            //sql
            $sql1 = $this->getInsertSqlPart($table,$data);
            $sql2 = $this->getReturnSqlPart($returning);
            $sql = $sql1.' '.$sql2;

            $this->ociParse($sql);

            $this->bolbNewDescs($returning);

            $this->ociExecute();

            $res = $this->blobSave($blob_datas);
            if($res){
                $this->ociCommit();
            }else{
                $this->ociRollback();
            }

            $this->freeBlobDecs();
            $this->ociFreeStatement();
            $this->close();

            return $res;
        }catch (\Exception $e){
            $this->setError($e->getMessage());

            $this->close();
        }
        return false;
    }

    protected function blobSave($blob_datas){
        $res = true;
        foreach($this->blob_decs as $kk=>$lobd){
            if(!$lobd->save($blob_datas[$kk])){
                $res = false;
                break;
            }
        }
        return $res;
    }

    protected function bolbNewDescs($returning){
        $this->blob_decs = [];
        foreach($returning as $k=>$d){
            $lob = $this->ociNewDescriptor(OCI_D_LOB);
            $this->blob_decs[$k] = $lob;
            ocibindbyname($this->stmt, $d, $lob, -1, OCI_B_BLOB);
        }
    }

    protected function setError($error=''){
        $this->error = $error ? $error : oci_error();
    }

    protected function freeBlobDecs(){
        foreach($this->blob_decs as $lobd){
            ocifreedesc($lobd);
        }
        $this->blob_decs = [];
    }

    protected function getUpdateSqlPart($table,$data,$where){
        $set_str = '';
        foreach($data as $k=>$d){
            $value = '';
            $val= $this->parseValue($d);
            if($val[0]=='raw'){
                $value .= $val[1];
            }else{
                $value .= "'{$val[1]}'";
            }

            $set_str .= strtoupper($k)."={$value}";
        }

        $set_str = rtrim($set_str,',');
        return "UPDATE {$table} SET {$set_str} WHERE {$where}";
    }

    protected function getInsertSqlPart($table,$data){
        $fileds = '';
        $values = '';
        foreach($data as $k=>$d){
            $fileds .= strtoupper($k).',';
            $val= $this->parseValue($d);
            if($val[0]=='raw'){
                $values .= $val[1].',';
            }else{
                $values .= "'{$val[1]}',";;
            }
        }

        $fileds = rtrim($fileds,',');
        $values = rtrim($values,',');
//        print_r([
//            rtrim($fileds,','),
//            rtrim($values,','),
//        ]);

        return "INSERT INTO {$table} ({$fileds}) VALUES ({$values})";
    }

    protected function getReturnSqlPart($returning){
        $part1 = $part2 = '';

        foreach($returning as $k=>$d){
            $part1 .= strtoupper($k).',';
            $part2 .= $d.',';
        }
        $part1 = rtrim($part1,',');
        $part2 = rtrim($part2,',');

        return "RETURNING {$part1} INTO $part2";
    }

    protected function parseValue($value){
        if(strpos($value,'raw:')!==false){
            return ['raw',str_replace('raw:','',$value)];
        }
        return ['str',$value];
    }


    public function getConn(){
        return self::$connection;
    }
    public function getStmt(){
        return $this->stmt;
    }

    public function close(){
        return oci_close(self::$connection);
    }

    public function getError(){
        return $this->error;
    }

    protected  function connect()
    {

//        $dsn = $this->parseDsn(self::$config);
        $dsn = self::$config['hostname'].':'.self::$config['hostport'].'/'.self::$config['database'];
        self::$connection = oci_connect(self::$config['username'],self::$config['password'],$dsn,'utf8');

        return self::$connection;
    }

    protected function ociParse($sql){
        $this->stmt = ociparse(self::$connection,$sql);
    }


    protected function ociNewDescriptor($type=OCI_D_LOB){
        return ocinewdescriptor(self::$connection, $type);
    }


    protected function ociExecute(){
        return ociexecute($this->stmt,OCI_DEFAULT);
    }

    protected function ociCommit(){
        ocicommit(self::$connection);
    }

    protected function ociRollback(){
        ocirollback(self::$connection);
    }

    protected function ociFreeStatement(){
        return ocifreestatement($this->stmt);
    }

}