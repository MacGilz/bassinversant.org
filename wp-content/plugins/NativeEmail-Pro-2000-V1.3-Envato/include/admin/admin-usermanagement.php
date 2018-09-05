<?php
// add email users by admin

	global $native_settings;
	
    require_once INCLUDEFILEURL.'/include/admin/templates/File_CSV_DataSource/DataSource.php';
	
	$response = '';
	$upgrademessage = '';
	
if(isset($_POST['import_into_csv']) && !empty($_POST['import_into_csv'])){
	if(($_FILES["csv_import"]["type"] == "text/csv" or "application/vnd.ms-excel" == $_FILES["csv_import"]["type"] or "application/x-msdownload" == $_FILES["csv_import"]["type"]) ){
	    $time_start = microtime(true);
        $csv = new File_CSV_DataSource;
        $file = $_FILES['csv_import']['tmp_name'];
        
		if (!$csv->load($file)) {
            die('Failed to load file, aborting.');
        }
        //$csv->symmetrize();
		$emails = $csv->connect();
		$newobj = new emailalertpro_commonclass;
		foreach($emails as $email){
				if(NativeEmail_check_user_status()){
						$message = 'Please upgrade your subscription';
					}
				else{
						$newobj->email_alert_import_user( $email , $catids = null );	
						$message = '<h3>emails from file successfully imported</h3>';
				}	
			}
	}
	else{
		$message = '<h3>error importing emails , please try again</h3>';
		}
		echo "<script type='text/javascript'>
			jQuery(document).ready(function(){
					jQuery('#myModal').modal('show');
			});
		</script>";
}

if(isset($_POST['adduser']) && $_POST['adduser'] == 'Subscribe'){// add user and state is active
		$comma_separated_category = '';
		$comma_separated_emails = $_POST['email_addresses'];	// comma separated email addresses
	
		
		if(!empty($_POST['category_to_']))
			$comma_separated_category = implode(',', $_POST['category_to_']);
		
		if( $comma_separated_emails != '' )
				$emails = explode( ',' , $comma_separated_emails );
		if(NativeEmail_check_user_status()){
						$upgrademessage = 'Please upgrade your subscription.';
					}
		elseif(!empty($emails)){
				foreach($emails as $key => $email ){	
					$staus = $admin_settings->add_subscriber($email , 'active' , $comma_separated_category , $_POST['selected_category_for_db'] , $_POST['selected_post_type_for_db'] );
						if($staus == "error")
								$response.= $email.',';
				 }
		}
		echo "<script type='text/javascript'>
						jQuery(document).ready(function(){
								jQuery('#myModal').modal('show');
						});
						</script>";
	}

if(isset($_POST['unsubscribe']) && !empty($_POST['unsubscribe'])) // update  / add user state is unactive
	{
		$comma_separated_emails = $_POST['email_addresses'];				// comma separated email addresses
		$comma_separated_category = '';
			
		if(!empty($_POST['category_to_']))
			$comma_separated_category = implode(',', $_POST['category_to_']);
		
		if( $comma_separated_emails != '' )
				$emails = explode( ',' , $comma_separated_emails );
		
		if(!empty($emails)){
				foreach($emails as $key => $email ){
					$staus = $admin_settings->add_subscriber($email , 'unactive' , $comma_separated_category , $_POST['selected_category_for_db'] , $_POST['selected_post_type_for_db'] );
						if($staus == "error")
							$response.= $email.',';
				 }
		}
		echo "<script type='text/javascript'>
						jQuery(document).ready(function(){
								jQuery('#myModal').modal('show');
						});
						</script>";
	}	
	
if(isset($_GET['action']) && $_GET['action'] == 'del'){
		$id = $_GET['id'];
		$res = $admin_settings->remove_subscriber($id);
		echo "<script type='text/javascript'>
						jQuery(document).ready(function(){
								jQuery('#myModal').modal('show');
						});
						</script>";
	}
 
    
if($response)
		print '<h4>Emails are not inserted   <b>'.$response.'</b></h4>';
		
?>	

	
	<div class="layout-app">
		<div class="preheading widget">
                    <span class="text-left bg-title h1"></span>
                    <!---<input type="submit" value="Submit" name="submit" class="button-primary1 emailprobutton pull-right btn btn-primary btn-sm strong">--->
                 <div class="clearfix"></div>
        </div> 
		
<?php		

			@$pg    =  ($_GET['pg'] > 0)?$_GET['pg']:1;
			@$start =  ($_GET['pg'] > 0)?$_GET['pg']:0;
			@$limit =  ($_GET['limit'] > 0)?$_GET['limit']:20;
			@$order =  $_GET['order'];
			@$email =  $_GET['email'];
			@$filter = $_GET['filter'];
			$id = 1;
			
			if(isset($_GET['pg']) && $_GET['pg'] != '' && $_GET['pg'] > 0){
							$nxt 	= $_GET['pg'] + $limit;
							$pre 	= $_GET['pg']- $limit;
							$start	= $start * $limit;
										
						}		
					else{
							$pg = 0;
							$nxt = @$_GET['pg'] + $limit;
							$pre = 0;	
						}	
			
			
			
//			unset($subscribers['total_count']);
				if(isset($_GET['order']) && $_GET['order'] != '')
						$order = $_GET['order'];
					else
						$order = 'id';
				
				if(isset($_GET['email']) && $_GET['email'] != '')
							$email = $_GET['email'];
				
				if(isset($_GET['sort']) && $_GET['sort'] == 'ASC'){
					$sort = 'DESC';
				}
				else{
					$sort = 'ASC';
				}
					
					
					
			$baseurl = "pg=$pg&limit=$limit&email=$email&filter=$filter&sort=$sort";
			
			
			
			$args = array( 'page' => $start , 'limit'=>$limit , 'order' =>$order  , 's' => $email , 'filter' => $filter );
			
			$subscribers = $admin_settings->get_subscribers_list($args);
			
			$total_count = $subscribers['total_count'];
			
		
		if(isset($message))
		echo '<div class="message" >'.$message.'</div>';
?>			
		<div class="innerLR">
			<div class="form-horizontal row">
		
				<form action="" method="post" name="register_user" enctype="multipart/form-data">
		
					<div  id="emailalertpro_add_user" class="row">
							<div><input type="hidden" name="emailalert_admin" /></div>
							
							<div class="col-lg-6" style='color:#6FA362'>
									<?php if($upgrademessage){ echo '<h4 clss="col-lg-7"><b>Subscriber limit reached. '.$upgrademessage.'</b></h4>';}?>
							</div>	
					
							<div class="col-lg-12">
									<h4 class="innerTB">Add/Remove users. Enter addresses, one per line or comma-separated.</h4>
							<div class="col-lg-6">
									
									<textarea rows="4" cols="55" name="email_addresses"></textarea>
							<?php			
								echo "<div class=\"submit\" style=\"border-top: none;\">
									<input type=\"submit\" class=\"button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong\" name=\"adduser\" value=\"Subscribe\" />";
								echo "&nbsp;<input type=\"submit\" class=\"button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong\" name=\"unsubscribe\" value=\"" . __('Unsubscribe', 'subscribe2') . "\" /></div>";
							?>	
							</div>
							
							<div class="col-lg-4">
								<div class="widget widget-body-white padding-none">
									<!-- Widget heading -->
							<div class="bg-gray innerAll">
								<h4>
									Select categories
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span id="">
										<a target="_blank" class="button button-small" href="<?php echo admin_url('admin.php?page=nativeemailpro&tab=widget');?>">Change category type</a>
									</span>
								</h4>
								
							</div>
							<!-- // Widget heading END -->
							
							<div class="widget-body">
									<div class="innerAll">
										<div class="media half">
										   <?php echo $admin_settings->checkbox_selection_process();?> 
											<?php echo 	$admin_settings->get_all_category_list();?>
										</div>		
									</div>
							</div>
								
							</div>	
							</div>
							
							<div class="col-lg-2">
							</div>
						</div>
					</div>
		<!-- Widget -->
	<div class="widget widget-heading-simple widget-body-white">
		
		<!-- Widget heading -->
		<div class="widget-head">
			
		</div>
		<!-- // Widget heading END -->
		
		<div class="widget-body">
			<div class="row">
				<div class="col-md-6">
						<div class="col-md-12">
							<h4 class="heading">Import CSV file</h4>
						</div>	
						<div class="col-md-12">
							<div class="fileupload fileupload-new margin-none" data-provides="fileupload">
								<div class="input-group">
									<div class="form-control col-md-3"><i class="fa fa-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
									<span class="input-group-btn">
										<span class="btn btn-default btn-file">
											<span class="fileupload-new">Select file</span>
											<span class="fileupload-exists">Change</span>
											<input type="file" class="margin-none" name="csv_import"/>
										</span>
										<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-12 h1">
							<input type="submit" class="button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong" name="import_into_csv" value="Import" />
							
						</div>	
</div>
				<div class="col-md-6">
				<div class="fileupload fileupload-new margin-none" data-provides="fileupload">
					<h4 class="heading">Export CSV file</h4>
					
					<input type="submit" class="button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong" name="export_into_csv" value="Export" />
				</div>
				</div>
			</div>
		</div>
	</div>
	<!-- // Widget END -->

	<!-- Widget -->
		
        </form>
        
		<div class="widget">	
        	<form method="get" action="" name="member_form" class="row widget-body">
            <input type="hidden" name="page" value="nativeemailpro" />
            <input type="hidden" name="tab" value="registered" />
			<div class="col-lg-12">		
					<div class="col-lg-6"><h4>Current registered users</h4>
					</div>
					<div class="col-lg-6" style='color:#6FA362'>
						<?php //if($upgrademessage){ echo '<h4 clss="col-lg-7"><b>Subscriber limit reached. '.$upgrademessage.'</b></h4>';}?>
					</div>	
				</div>	
            <div class="">
            		<div class="col-lg-12">
                    	<div class="col-lg-4">
            				<div>
                            	<p>
                                	
                                	<input type="text" name="email" value="<?php echo @$_GET['email']; ?>"  style="margin-right: 4px;"/>
                                    <input type="submit" value="Search By Email" name="search" class="button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong"/>
                                </p>
                            </div>				
                    	</div>
                       <div class="col-lg-6">
                       			<div class="filter_control">
									<div class="col-lg-3 user-filter">
									<select name="filter" class="" id="select2_2">
										<option value="1" <?php echo (@$_GET['filter'] == '1') ? 'selected="selected"' : ''; ?>>Active</option>
										<option value="0" <?php echo (@$_GET['filter'] == '0') ? 'selected="selected"' : ''; ?>>Inactive</option>
									</select>&nbsp;
									</div>
									<input type="submit" value="Filter" class="button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong" />	
								</div>
						</div>
                    </div>
        	</div>
            
			<table class="register_user col-lg-12"  bgcolor="#CCCCCC">  
        <?php
				$next = "<a class='' href='?page=nativeemailpro&tab=registered&order=$order&email=$email&pg=$nxt#DataTables_Table_0'>Next -></a>";
				$prev = "<a class='' href='?page=nativeemailpro&tab=registered&email=$email&pg=$pg#DataTables_Table_0'><- Prev</a>";
			?>
            </table>
            
          </form> 
		
			</div>
		 </div>
</div>		    
   </div>
   
   <div class="dataTables_scroll">
			<div class="dataTables_scrollBody">
				<table class="dynamicTable tableTools table table-striped checkboxs dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
					<thead>
						
					</thead>

	<!-- Table heading -->
	
	<!-- // Table heading END -->
	
	<!-- Table body -->
	
	<!-- // Table body END -->
	
	<tbody role="alert" aria-live="polite" aria-relevant="all">
		<tr class="gradeX selectable odd">
				<?php	$url_prefix = '?page=nativeemailpro&tab=registered&'.$baseurl; ?>
					<th><a href="<?php echo $url_prefix;?>&order=id#DataTables_Table_0">ID</a></th>
                    <th><a href="<?php echo $url_prefix;?>&order=email#DataTables_Table_0">Email</a></th>
                    <th><a href="<?php echo $url_prefix;?>&order=cat_ids#DataTables_Table_0">Selected Cats</a></th>
					<th><a href="<?php echo $url_prefix;?>&order=post_type#DataTables_Table_0">Post Type</a></th>
					<th><a href="<?php echo $url_prefix;?>&order=category#DataTables_Table_0">Taxonomy Type</a></th>
                    <th><a href="<?php echo $url_prefix;?>&order=date#DataTables_Table_0">Date</a></th>
                    <th><a href="<?php echo $url_prefix;?>&order=active#DataTables_Table_0">Posts</a></th>
                    <th><a href="<?php echo $url_prefix;?>&order=active#DataTables_Table_0">State</a></th>
                    <th>Remove</th>				
			</tr>
<?php 
$id = 1;

if( $subscribers['total_count'] > 0) foreach($subscribers as $key =>$subscriber): 
		if(isset($subscriber->email) && is_email($subscriber->email)){	
?>
			<tr class="gradeX selectable odd">		
<?php
				
					$id++;
					$user_id = $subscriber->id;
					$taxonomy_types	 = $subscriber->category;
					$post_type	 = $subscriber->post_type;
					if($subscriber->active == 1 ) $state = 'active'; else $state = 'unactive';
					
					$checkuserpost =  "<a href='".admin_url("admin-ajax.php?action=get_email_perview&native_user_id=$user_id")."' target='_blank'>Scheduled Posts</a>";
					
					echo "<td>$user_id</td>";
					echo "<td>$subscriber->email</td>";
					//echo "<td>$subscriber->cat_ids</td>";
					$names = $admin_settings->get_subscribed_category_name($subscriber->cat_ids , $taxonomy_types);
					echo "<td>$names</td>";	
					echo "<td>$post_type</td>";		
					echo "<td>$taxonomy_types</td>";		
					echo "<td>$subscriber->date</td>";
					echo "<td>$checkuserpost</td>";
					echo "<td>$state</td>";
					echo "<td><a href='?page=nativeemailpro&tab=registered&id=$user_id&action=del#DataTables_Table_0'>Delete</a></td>";		
?>			
			</tr>
<?php 
					}
	endforeach; ?>			
		</tbody>
	</table>
                            
    
    <nav>
	<ul class="pagination" id="pagination">
	<?php
			$adjacents = 5;
			$tpages = ceil($total_count/$limit)-1;
			$pmin=($pg>$adjacents)?($pg - $adjacents):1;
			$pmax=($pg<($tpages - $adjacents))?($pg + $adjacents):$tpages;
			$prevlabel = "&lsaquo; Prev";
           
			
			
			if($pg > 1){
				echo "<li><a href=\"?page=nativeemailpro&tab=registered&order=$order&email=$email&pg=0#pagination\">First</a>\n</li>";
			}
			
			  if ($pg == 0) {
				//	echo "<li ><span>".$prevlabel."</span></li>";
				} elseif ($pg == 1) {
					echo "<li><a href=\"?page=nativeemailpro&tab=registered&order=$order&email=$email&pg=0#pagination\">".$prevlabel."</a>\n</li>";
				} else {
					echo "<li><a href=\"?page=nativeemailpro&tab=registered&order=$order&email=$email&pg=".($pg - 1)."#pagination\">".$prevlabel."</a>\n</li>";
				}
				
			$reload  = "DataTables_Table_0";
			$out = '';	
			  for ($i = $pmin; $i <= $pmax; $i++) {
				 
					if ($i == $pg) {
						$out.= "<li class=\"active\"><a href=''>".$i."</a></li>\n";
					} elseif ($i == 1) {
						$out.= "<li><a href=\"?page=nativeemailpro&tab=registered&order=$order&email=$email&pg=$i#pagination\">".$i."</a></li>";
					} else {
						$out.= "<li><a href=\"?page=nativeemailpro&tab=registered&order=$order&email=$email&amp;pg=".$i."#pagination\">".$i. "</a>\n</li>";
					}
				}
		echo $out;
			
			echo '<li>';
			
			  if ($pg < $tpages) {
			  
					echo "<a href=\"?page=nativeemailpro&tab=registered&order=$order&email=$email&pg=".($pg + 1)."#pagination\">Next</a>\n";
						if($pg > 1){ echo "<a href=\"?page=nativeemailpro&tab=registered&order=$order&email=$email&pg=$tpages#pagination\">Last</a>\n";}
				  }
			else {
					//echo "<span style='font-size:11px'>".$nextlabel."</span>\n";
				}
				
			echo '</li>';
			
			?>
    </ul>
    </nav>
	<p>Total <?php echo $total_count; ?> users found</p>
</div>
</div>