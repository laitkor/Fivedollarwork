                  <div>  <?php echo $gigId[0]['User']['username'];?> : I Will <?php echo $gigId['0']['Gig']['title'];?> for $<?php echo $gigId[0]['Gig']['price'];?></div>
                    
			  <div><img src="/uploads/gig_img/<?php if($gigId[0]['Gig']['image']==''){?>noimage.jpg <?php } else { echo $gigId[0]['Gig']['image']; } ?>" width="350px" height="200px" />
			</div>
            <div><?php echo $gigId[0]['Gig']['description'];?></div>
