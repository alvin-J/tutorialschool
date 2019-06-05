<?Php 
    $tname = null;
    $ttype = null;
    $age   = null;
    $exp   = null;
    $rate  = null;
    $per   = null;
    $skype = null;
    $dpt   = null;
    $email = null;
    $pwd   = null;

    if (count($data) > 0) {
        $tname = $data[0]->name;
        $ttype = $data[0]->teachertype;
        $age   = $data[0]->age;
        $exp   = $data[0]->exp;
        $rate  = $data[0]->rate;
        $per   = $data[0]->per;
        $skype = $data[0]->skypename;
        $dpt   = $data[0]->dept; 
        $email = $data[0]->username;
//       $pwd   = $data[0]->name;
    }

    $teachertype = ["Teacher 1","Teacher 2"];

?>
<p class='mat_head'> <span> ADD TEACHER </span> 
    <i class="fa fa-times closethewin" id="cancelthis"></i> 
</p>
    	<div class='bodydiv paddit'>

            <div class='row getmarginbot'>
            	<div class='col-md-6'>
            		<div class='input_holder'>
                        <p> TEACHER'S NAME </p>
                        <input type='text' id='tname' value='<?php echo $tname; ?>'/>
                    </div>
            	</div>
            	<div class='col-md-6'>
            		<div class='input_holder'>
                        <p> TEACHER TYPE </p>
                        <select style='display:block;' class='ttype' id='ttypeid'>
                        	<?php
                                foreach($teachertype as $tt) {
                                    $selected = ( strcmp( strtolower(trim($tt)),strtolower(trim($ttype)) ) == 0  )?"selected='selected'":null;
                                    echo "<option {$selected}>{$tt}</option>";
                                }
                            ?>
                        </select>
                    </div>
            	</div>
            </div>

	            <div class='row getmarginbot'>
	            	<div class='col-md-3'>
            		<div class='input_holder'>
                        <p> AGE </p>
                        <input type='text' id='t_age' value='<?php echo $age; ?>'/>
                    </div>
            	</div>
            	<div class='col-md-3'>
					<div class='input_holder'>
                        <p> YEARS OF EXPERIENCE </p>
                        <input type='text' id='tyexp' value='<?php echo $exp; ?>'/>
                    </div>
            	</div>
            	<div class='col-md-3'>
            		<div class='input_holder'>
                        <p> RATE </p>
                        <input type='text' id='trate' value='<?php echo $rate; ?>'/>
                    </div>
            	</div>
            	<div class='col-md-3'>
            		<div class='input_holder'>
                        <p> PER </p>
                        <select style='display:block;' class='ttype' id='tper' value='<?php echo $per; ?>'>
                        	<option> HOUR </option>
                        </select>
                    </div>
            	</div>
            </div>

            <div class='row getmarginbot'>
            	<div class='col-md-4'>
            		<div class='input_holder'>
                        <p> SKYPE ID </p>
                        <input type='text' id='tskypeid' value='<?php echo $skype; ?>'/>
                    </div>
            	</div>
            	<div class='col-md-8'>
					<div class='input_holder'>
                        <p> DEPARTMENT </p>
                        <input type='text' id='tdept'value='<?php echo $dpt; ?>'/>
                    </div>
            	</div>
            </div>

            <div class="row" style='margin-top: 17px;'>
                <div class="col-md-2">
                    <p class="modbothead" style='color: #878686;font-size: 14px;'> INFORMATION </p>
                </div>
                <div class="col-md-10">
                    <hr class="modbothr" style='border-color: #ccc;'> 
                </div>
            </div>

            <div class='row'>
            	<div class='col-md-4'>
            		<div class='input_holder'>
                        <p> EMAIL ADDRESS </p>
                        <input type='text' id='temail' class='getmarginbot' value="<?php echo $email; ?>" disabled="disabled"/>
                        <span class='dupemail'>
                        	<i class="material-icons dp48 iconbtn">done</i> 
                        	<span id='emailstat'> EMAIL ADDRESS IS AVAILABLE </span>
                       	</span>
                    </div>
                    
            	</div>
            	<div class='col-md-4'>
            		<div class='input_holder'>
                        <p> PASSWORD </p>
                        <input type='password' id='tpword'/>
                    </div>
            	</div>
            </div>

            <div class='row getmarginbot bordertop_create'>
            	<div class='col-md-12' style='text-align: right;'>
                    <span id='saveteacher'> Update edits </span>
            		<!--button class='thebutton' id='saveteacher'> SET ACTIVE </button-->
                    <?php 
                        if ($data[0]->status == 0) {
                            echo "<button class='thebutton' id='setactive'> ACTIVATE </button>";
                        } else if ($data[0]->status == 1) {
                            echo "<button class='thebutton inactive' id='setinactive'> DEACTIVATE ACCOUNT </button>";
                        }   
                    ?>
                    
            	</div>
            </div>
        </div>

<style>

	#addmodule {
		overflow-y: scroll;
	}

	input[type="text"],
	input[type="password"] {
		border: 1px solid #e4e4e4;
	}

	#emailstat {
		font-size: 9px;
	}

	.iconbtn {
		position: relative;
		top: 7px;
	}

	.bordertop_create {
		border-top: 1px solid #CCCCCC;
	}

</style>