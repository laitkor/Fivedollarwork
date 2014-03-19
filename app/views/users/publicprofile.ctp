<?php $title="Balance";$this->set('title_for_layout', $title);?><h3 class="blog-title"><a href="#" title="<?php echo $title;?>"><?php echo $title;?></a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                                            <div id="comment-2" class="comment alt">
                            <div >
                                <cite>
                                    <a class="url" rel="external nofollow" title="<?php echo $record['User']['username'];?>"><?php 
									 if(is_numeric($record['User']['username'])) {echo $record['User']['name']; }else {echo $record['User']['username'];}
									?></a>
                                    <small>
                                        <a>Joined: <?php echo $ago['create'];?>. • last activity: <?php echo $ago['update'];?></a></small>
                                </cite>                                                               
                                <p><div class="wp-caption alignleft"><?php if($record['User']['image']!="") { echo '<img alt="'.$record['User']['username'].'" src="/uploads/profile_img/'.$record['User']['image'].'" class="avatar">';} else {echo '<img alt="'.$record['User']['username'].'" src="/uploads/profile_img/no_icon.gif">';}?></div>
                                <?php if(isset($checkLogin)) {?>
                                <a href="/users/compose/<?php echo $record['User']['username'];?>" title="Contact to <?php echo $record['User']['username'];?>">Contact</a><?php } else {?><a href="/users/profile" title="Edit">Edit</a><?php } ?><br/><br/><?php echo $record['User']['description'];?></p>
                            </div>
                            <div class="clear"></div>
                        </div>
</div>