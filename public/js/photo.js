function resize(e){
	var sketch_size = 800;
	if (e.width > sketch_size) { 
		e.width = sketch_size;
	}
	
	var left = Math.round((900 - e.width) / 2);
	e.style.left = left + 'px';

}