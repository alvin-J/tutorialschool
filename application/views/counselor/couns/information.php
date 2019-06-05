<div class='col-md-9' style='border-right: 1px solid #ccc;'>
                    <table class='infotable'>
                        <tr>
                            <th colspan=2 class='suphead'> Personal Information</th>
                        </tr>
                        <tr>
                            <th> Name </th>
                            <td> <?php echo $personaldata[0]->name; ?> </td>
                        </tr>
                        <tr>
                            <th> Purpose </th>
                            <td> <?php echo $personaldata[0]->bookingreason; ?> </td>
                        </tr>
                        <tr>
                            <th> Requested Date </th>
                            <td> <?php  echo date("F d, Y @ h:i A", strtotime($personaldata[0]->date_time)); ?> </td>
                        </tr
                        <tr>
                            <th colspan=2 class='suphead'> Feedback from teachers </th>
                        </tr>

                        <?php if (count($feedback) > 0){ $i = 0;?>
                            <?php foreach($feedback as $f){ 
                                $class = ($i%2==0)?"greyit":"whiteit";
                                ?>
                                <tr class='<?php echo $class; ?>'>
                                    <th> <?php //echo date("F d, Y", strtotime($f->dateoffb));
                                    echo $f->name; ?></th>
                                    <td>
                                        <strong> <h4> <?php echo date("F d, Y", strtotime($f->dateoffb)); //echo $f->name; ?> </h4> </strong>
                                        <p> <?php echo $f->feedback; ?> </p>
                                    </td>
                                </tr>
                            <?php $i++;} ?>
                        <?php } else { ?>
                            <tr> <td colspan="10" style='text-align: center;'> No feedback from teachers </td> </tr>
                        <?php } ?>
                    </table>
</div>
                <div class='col-md-3'>
                    <button class='btn btn-primary fullwidth' 
                            id='callstudent' 
                            data-href='<?php echo base_url(); ?>classroom/start/<?php echo $personaldata[0]->classroomid; ?>'> Call </button>
                    <button class='btn btn-primary fullwidth' id='fillnotes' data-stdid='<?php echo $personaldata[0]->studentid; ?>'> Fill-in Notes </button>
                    <hr style='margin-top: 10px;'/>
                    <button class='btn btn-success fullwidth' id='complete' data-bl_id = '<?php echo $personaldata[0]->bl_id; ?>'> Mark as Complete </button>
                </div>