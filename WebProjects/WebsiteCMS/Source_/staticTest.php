<?php
include 'data/lib/error_reporter.php';

class staticTest{
    static $count=0;
    function staticTest(){
          staticTest::$count++;
    }
}
new staticTest();
echo staticTest::$count."<br>";
new staticTest();
echo staticTest::$count."<br>";
new staticTest();
echo staticTest::$count."<br>";
?>
