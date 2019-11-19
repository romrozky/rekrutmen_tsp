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
		
		
	</div>
	
  <!-- Row -->
  


<script type="text/javascript">
  
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