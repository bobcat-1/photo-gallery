function resize(e){
	var sketch_size = 150;
	if (e.height>sketch_size & e.height>sketch_size) { 
		if (e.height > e.width) {
			e.height = sketch_size;
		} else {
			e.width = sketch_size;
		}
	}
	if (e.height<sketch_size) {
		var top = Math.round((sketch_size - e.height) / 2);
		e.style.top = top + 'px';
	}
	if (e.width<sketch_size) {
		var left = Math.round((sketch_size - e.width) / 2);
		e.style.left = left + 'px';
	}
}