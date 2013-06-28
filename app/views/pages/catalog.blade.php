@extends('layouts.split')

@section('content')

{{ HTML::style('css/masonry.css') }}

<p>
	<div id="item-container">
		@for($i = 1; $i < 23;$i++)
			<?php $j = ( $i < 12)? $i: $i - 11; ?>
			<div class="item">
				<div class="title-box">
					<h1 class="item-title">title</h1>
					<span class="maker">by DuraSlide</span>
				</div>
				<div class="tags">tags, tags, tags</div>
				<img src="{{ URL::to('images/dummy/'.$j.'.jpg') }}" alt="{{ $i }}" />

			</div>
		@endfor

	</div>

</p>

<script type="text/javascript">
	$(document).ready(function(){
		$('#item-container').imagesLoaded( function(){
			$('#item-container').isotope({
			  // options
			  	itemSelector : '.item',
				layoutMode: 'fitRows',
			    resizesContainer: true
			});			
		});
	});
</script>

@stop