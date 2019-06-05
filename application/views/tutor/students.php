<div id="page-wrapper">
    <div class="header"> 
        <div class='row getmarginbot'>
            <div class='col-md-12'>
                <h4 class="page-header"> MY STUDENTS </h4>
            </div>
        </div>
    </div>
    <div id="page-inner">
    	<div class="row">
    		<div class='col-md-6'>
                <div class='card'>
                    <div class='card-action' style=''> Students who booked </div>
                    <div class='card-content'> 
                        <?php if(count($lessons) > 0): ?>
                            <ul class='paysliplist'>
                                <!--li>
                                    <table class='tblstud'>
                                        <tr>
                                            <th> Student Name </th>
                                            <td> Alvin Merto </td>
                                        </tr>
                                        <tr>
                                            <th> Date of Class </th>
                                            <td> Feb. 2X, 2XXX </td>
                                        </tr>
                                        <tr>
                                            <th> Student Timezone </th>
                                            <td> Osaka/Japan </td>
                                        </tr>
                                        <tr>
                                            <th>  </th>
                                            <td> <button class='waves-effect waves-light btn'> Go to Classroom </button> </td>
                                        </tr>
                                    </table>
                                </li-->
                                <?php
                                    foreach($lessons as $ls) {
                                        echo "<li>";
                                            echo "<table class='tblstud'>";
                                                echo "<tr>";
                                                    echo "<th> Student Name </th>";
                                                    echo "<td> {$ls->name} </td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                    echo "<th> Date of Class </th>";
                                                    echo "<td> ".date("l - F d, Y @ h:i A", strtotime($ls->date_time))."</td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                    echo "<th> Student Timezone </th>";
                                                    echo "<td> {$ls->timezone} </td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                    echo "<th>  </th>";
                                                    echo "<td> <a class='waves-effect waves-light btn' href='".base_url()."/classroom/waiting/".$ls->classroomid."'> Go to Classroom </a> </td>";
                                                echo "</tr>";
                                            echo "</table>";
                                        echo "</li>";
                                    } // http://anwdev.ariesvrebuldad.com/classroom/waiting/245b409bc8375558913d4
                                ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!--div class='col-md-6'>
                <div class='card'>
                    <div class='card-action'> Student Details </div>
                    <div class='card-content'>

                    </div>
                </div>
            </div-->
        </div>
    </div>
</div>