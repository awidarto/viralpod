@extends('layouts.front')

@section('content')

{{ HTML::style('css/masonry.css') }}

<p>
	<div id="item-container">
		@for($i = 1; $i < 23;$i++)
			<?php $j = ( $i < 12)? $i: $i - 11; ?>
			<div class="item" data-title="<h1>DuraBrite {{ $i }}</h1>by Duralite" data-caption="tags,tags<br />tags,tags" >
				<a href="" >
					<img src="{{ URL::to('images/dummy/'.$j.'.jpg') }}" alt="{{ $i }}" />
				</a>
			</div>
		@endfor

	</div>

</p>

<script type="text/javascript">
	$(window).load(function () {
	    $(document).ready(function(){
	        collage();
	    });
	})

	function collage() {
		$('#item-container').removeWhitespace().collagePlus({
			'fadeSpeed' : 2000,
            'targetHeight' : 250
		})
		.collageCaption({
			'opacity' : 0.65,
			'speedin' : 300,
			'speedout' : 500
		});
		
		/*
		$('.item img').each(function(e){
			var el = $(this).parent().parent();

			console.log(el);
			
			var title = el.data('title');
			var maker = el.data('maker');
			var tags = el.data('tags');

			var caption = '<div class="title-box"><h1 class="item-title">' + title + '</h1><span class="maker">'+ maker +'</span></div><div class="tags">' + tags + '</div>';
			//console.log(caption);
			
			$(this).parent().append(caption);

		});
		*/
	};

    var resizeTimer = null;
    $(window).bind('resize', function() {
        // hide all the images until we resize them
        $('.item-container .item').css("opacity", 0);
        // set a timer to re-apply the plugin
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(collage, 200);
    });
</script>

@stop