<?php
error_reporting(0);

/*
By default the loop will run by column
Changed it to row wise
*/
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

            $aisle_seat = $this->allocate_aisle_seats($alignseat,$passenger);
            $window_seat = $this->allocate_window_seats($aisle_seat,$passenger);
            $middle_seat = $this->allocate_middle_seats($window_seat,$passenger);
            return $middle_seat;
        }
    }

    //Loop seats and assign aisle seats
    private function allocate_aisle_seats($get_row_seats,$passenger){
        if(!empty($get_row_seats)){
            foreach($get_row_seats as $key_main => $row_seats){
                //To know first and last row
                $first_arr_key = array_key_first($row_seats);
                $last_arr_key = array_key_last($row_seats);

                //loop each row val and assign aisle seats
                foreach($row_seats as $key_row => $rows){
                    if(!$rows)
                        continue;

                    //Get first and last seat in row and assign aisle    
                    $first_aisle_key = array_key_first($rows);
                    $last_aisle_key = array_key_last($rows);

                    //Assign values to array
                    switch($key_row){
                        //First row in a seat
                        case $first_arr_key;
                            if($key_row == $first_aisle_key){
                                if($this->aisle < $passenger){
                                    $this->aisle++;
                                    $get_row_seats[$key_main][$key_row][$last_aisle_key]= $this->aisle.'-aisle';
                                }else{
                                    $get_row_seats[$key_main][$key_row][$last_aisle_key]= '0'.'-aisle';
                                }
                            }
                        break;
                        //Last row in a seat
                        case $last_arr_key;
                            if($key_row == $last_arr_key){
                                if($this->aisle < $passenger){
                                    $this->aisle++;
                                    $get_row_seats[$key_main][$key_row][$first_aisle_key]= $this->aisle.'-aisle';
                                }else{
                                    $get_row_seats[$key_main][$key_row][$first_aisle_key]= '0'.'-aisle';
                                }
                            }
                        break;
                        //if row is set as 2 in a seat
                        default:
                            if($this->aisle < $passenger){
                                $this->aisle++;
                                $get_row_seats[$key_main][$key_row][$first_aisle_key]= $this->aisle.'-aisle';
                                $this->aisle++;
                                $get_row_seats[$key_main][$key_row][$last_aisle_key]= $this->aisle.'-aisle';
                            }else{
                                $get_row_seats[$key_main][$key_row][$first_aisle_key]= '0'.'-aisle';
                                $get_row_seats[$key_main][$key_row][$last_aisle_key]= '0'.'-aisle';
                            }
                        break;
                    }
                }  
            }
        }
        return $get_row_seats;  
    }

    //Loop seats and assign window seats
    private function allocate_window_seats($get_row_seats,$passenger){
        //assign last seat number to window variable
        $this->window = $this->aisle;
        if(!empty($get_row_seats)){
            foreach($get_row_seats as $key_main => $row_seats){
                //To know first and last row
                $first_arr_key = array_key_first($row_seats);
                $last_arr_key = array_key_last($row_seats);

                //loop each row val and assign window seats
                foreach($row_seats as $key_row => $rows){
                    if(!$rows)
                        continue;

                    //Get first and last seat in row and assign window 
                    $first_aisle_key = array_key_first($rows);
                    $last_aisle_key = array_key_last($rows);

                    switch($key_row){
                        //First seat in a row on column
                        case $first_arr_key;
                            if($key_row == $first_aisle_key){
                                if($this->window < $passenger){
                                    $this->window++;
                                    $get_row_seats[$key_main][$key_row][$first_aisle_key]= $this->window.'-window';
                                }else{
                                    $get_row_seats[$key_main][$key_row][$first_aisle_key]= '0'.'-window';
                                }
                            }
                        break;
                        //Last seat in a row on column
                        case $last_arr_key;
                            if($key_row == $last_arr_key){
                                if($this->window < $passenger){
                                    $this->window++;
                                    $get_row_seats[$key_main][$key_row][$last_aisle_key]= $this->window.'-window';
                                }else{
                                    $get_row_seats[$key_main][$key_row][$last_aisle_key]= '0'.'-window';
                                }
                            }
                        break;
                    }
                }
            }
        }
        return $get_row_seats;  
    }
    //Loop seats and assign middle seats
    private function allocate_middle_seats($get_row_seats,$passenger){
        //assign last seat number to middle variable
        $this->middle = $this->window;
        if(!empty($get_row_seats)){
            foreach($get_row_seats as $key_main => $row_seats){
                //To know first and last row
                $first_arr_key = array_key_first($row_seats);
                $last_arr_key = array_key_last($row_seats);

                //loop each row val and assign middle seats
                foreach($row_seats as $key_row => $rows){
                    if(!$rows)
                        continue;

                    //Get first and last seat in row to avoid assigning value 
                    $first_aisle_key = array_key_first($rows);
                    $last_aisle_key = array_key_last($rows);

                    //loop each Seat to know middle seats
                    foreach($rows as $row_key => $val){
                        if($row_key !=$first_aisle_key && $row_key !=$last_aisle_key){
                            if($this->middle < $passenger){
                                $this->middle++;
                                $get_row_seats[$key_main][$key_row][$row_key]= $this->middle.'-middle';
                            }else{
                                $get_row_seats[$key_main][$key_row][$row_key]= '0'.'-middle';
                            }
                        }
                    }
                       
                        
                }  
            }
        }
        return $get_row_seats;  
    }
}

/*$seating_array = [[3,2], [4,3], [2,3], [3,4]];
$passenger = 30;
$get_plane = new AirplaneSeating;
$plane = $get_plane->seating_arrangements($seating_array,$passenger);
*/
?>