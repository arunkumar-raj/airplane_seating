<?php
error_reporting(0);
class AirplaneSeating
{
 
    private $aisle = 0 ;
    private $window = 0 ;
    private $middle = 0 ;
 
    //Seating Arrangements 
    //Count arguments passed loop it 
    public function seating_arrangements($seat_values,$passenger){
        $alignseat = array();
        //[3,2]
        if(is_array($seat_values)){
            //Total count of input array
            $count_seat = count($seat_values);
            //Max count of column
            $maxVal = max(array_column($seat_values, '1'));
            //Min count of column
            $minVal = min(array_column($seat_values, '1'));

            //Looping input array
            $sum_of_column = 0;
            for($args=0; $args < $count_seat; $args++){

                //Split row and column
                list($row, $column) = $seat_values[$args];

                //Looping using max column 
                for($cols=1; $cols <= $maxVal; $cols++){
                    //restrict based on column value on input
                    if($cols <= $column){
                        $alignseat['column_'.$cols][] = range(1,$row);
                    }else{
                        $alignseat['column_'.$cols][] = null;
                    }
                }
            }
            return $alignseat;
        }
    }

}

$seating_array = [[3,2], [4,3], [2,3], [3,4]];
$passenger = 30;
$get_plane = new AirplaneSeating;
$plane = $get_plane->seating_arrangements($seating_array,$passenger);

?>