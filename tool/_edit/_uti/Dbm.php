<?php
@session_start();


class Dbm {
	public $conn;
	public function Dbm(){
        $host = "localhost"; 
        $user = "postgres"; 
        $pass = "4321"; 
        $db = "dcima"; 
        $this->conn = pg_connect("host=$host port=4321 dbname=$db user=$user password=$pass");		
	}
    public function getCount($sql){
    	//sample: $sql="SELECT count(*) FROM public.alert_history_locale WHERE alert_language='en'";
    	$result2 = pg_query($this->conn, $sql);
    	$count=0;
    	while ($row = pg_fetch_row($result2)) {
    		$count += $row[0];
    	}
    	return $count;
    }
    public function query($sql){
    	return pg_query($this->conn, $sql);
    	
    }
    
    public function exeq($sql){
    	return pg_query($this->conn, $sql);
    	 
    }
};//





?>
