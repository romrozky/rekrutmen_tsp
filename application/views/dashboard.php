<!-- Custom CSS -->
 <link href="<?= base_url() ?>assets/unit-carausel.css" rel="stylesheet">

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
    <div class="row">
		<?php
		if($this->session->userdata('userlevel')==1){
			?>
    	<div class="col-md-3">
            <div class="card card-inverse text-center" style="background: #7dbb36;">
                <div class="card-header">
                    <h3 class="m-b-0 text-white">Total Cabang</h3></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">
						<?=$total_cabang?>
						</h1>                    	
					</p>
				</div>
            </div>
		</div>
			<?php
			$colmd = 3;
		}else{
			$colmd = 4;
		}
		?>
    	<div class="col-md-<?=$colmd?>">
            <div class="card card-inverse text-center" style="background: #1d6ac0;">
                <div class="card-header">
                    <h3 class="m-b-0 text-white">Total User</h3></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">
                    	<?=$total_user?>
					</h1>                    	
                    </p>
                </div>
            </div>
        </div>
		<div class="col-md-<?=$colmd?>">
            <div class="card card-inverse text-center" style="background: #fbae3a;">
                <div class="card-header">
                    <h3 class="m-b-0 text-white">Total User Aktif </h3></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">
						<?=$total_user_aktif?>
					</h1>                    	                    	
                    </p>					
                </div>
				 
            </div>
        </div>
		<div class="col-md-<?=$colmd?>">
            <div class="card card-inverse text-center" style="background: #e84646;">
                <div class="card-header">
                    <h3 class="m-b-0 text-white">Total Barang </h3></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">
						<?=$total_barang?>
					</h1>                    	                    	
                    </p>					
                </div>
				 
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="card card-inverse text-center" style="background: #fcbe4a;">
                <div class="card-header">
                    <h3 class="m-b-0 text-white">Total Manajer </h3></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">	
						<?=$total_user_2?>
					</h1>                    	                    	
                    </p>					
                </div>
				 
            </div>
        </div>
		<div class="col-md-4">
            <div class="card card-inverse text-center" style="background: #fa5656;">
                <div class="card-header">
                    <h3 class="m-b-0 text-white">Total Admin </h3></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">
						<?=$total_user_3?>
					</h1>                    	                    	
                    </p>					
                </div>
				 
            </div>
        </div>
		<div class="col-md-4">
            <div class="card card-inverse text-center" style="background: #e81246;">
                <div class="card-header">
                    <h3 class="m-b-0 text-white">Total User </h3></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">
						<?=$total_user_4?>
					</h1>                    	                    	
                    </p>					
                </div>
				 
            </div>
        </div>
		
		<div class="col-md-12 downloadbarang" id='-' style='cursor: pointer;'>
            <div class="card card-inverse text-center" style="background: #a84541;">
                <div class="card-header">
                    <h3 class="m-b-0 text-white">Total Barang </h3></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">
						<?=$total_barang?>
					</h1>                    	                    	
                    </p>					
                </div>
				 
            </div>
        </div>
		<?php
		$z = $this->Db_model->get('kondisi');
		foreach($z->result() as $aa => $bb){
			$where = array();
			if($this->session->userdata('userlevel')>1){
				$where['user.cabang'] = $this->session->userdata('cabang');			
			}
			$where['detail_barang.kondisi'] = $bb->id;						
			$a = $this->Db_model->get('detail_barang','detail_barang.id',$where,'','','','',
					[
						['table' => 'user', 'on' => 'user.id = detail_barang.owner', 'pos' => 'left']
					]				
				);
			?>
		<div class="col-md-3 downloadbarang" id='<?=$bb->id?>' style='cursor: pointer;'>
            <div class="card card-inverse text-center" style="background: #1d6ac0;">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Total Barang <?=$bb->kondisi?></h4></div>
                <div class="card-body">
                    <p class="card-text angka-das">
                    <h1 class="m-b-0 text-white">
						<?=$a->num_rows()?>
					</h1>                    	                    	
                    </p>					
                </div>
				 
            </div>
        </div>
			<?php
		}
		?>
		
	</div>
	
  <!-- Row -->
  


<script type="text/javascript">
  $(document).on('click', '.downloadbarang', function () {
		location.href = '<?= site_url() ?>/Barang/downloadstatus/'  + $(this).attr('id');
	});
$('#carouselExample').on('slide.bs.carousel', function (e) {

  
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 4;
    var totalItems = $('.carousel-item').length;
    
    if (idx >= totalItems-(itemsPerSlide-1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i=0; i<it; i++) {
            // append slides to end
            if (e.direction=="left") {
                $('.carousel-item').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});


  $('#carouselExample').carousel({ 
                interval: 5000
        });


  $(document).ready(function() {
/* show lightbox when clicking a thumbnail */
    $('a.thumb').click(function(event){
      event.preventDefault();
      var content = $('.modal-body');
      content.empty();
        var title = $(this).attr("title");
        $('.modal-title').html(title);        
        content.html($(this).html());
        $(".modal-profile").modal({show:true});
    });

  });
</script>