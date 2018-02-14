function stopShowcase (e) {
    var camAnimEl = document.querySelector("#camAnim");
    
    camAnimEl.emit("endShowcase");
    document.querySelector('a-scene').removeEventListener('mousedown', stopShowcase);
    // console.log("removed");
}
var counter = 0,rotations;
var roomCount, markerCount = 10;
var rotationList = {}, roomOrder={}, markerList={};
// var r0_r1 = {x: -196, y: -8, z: -16},
//     r0_r2 = {x: 115, y: 2, z: -159},
//     r1_r0 = {x: -188, y: -15, z: -54},
//     r2_r0 = {x: 2, y: -19, z: -196},
//     r2_r3 = {x: 196, y: -12, z: 12},
//     r3_r4 = {x: -190, y: -22, z: -42},
//     r3_r5 = {x: 31, y: -7, z: 194},
//     r3_r2 = {x: 187, y: -5, z: 60},
//     r4_r3 = {x: 196, y: -5, z: 17},
//     r5_r3 = {x: 194, y: 2, z: 30};

// var r0 = {x: 1, y: -93, z: 0},
//     r1 = {x: 1, y: -124, z: 0},
//     r2 = {x: 0, y: -88, z: 0},
//     r3 = {x: -5, y: -294, z: 0},
//     r4 = {x: -1, y: -123, z: 0},
//     r5 = {x: -4, y: -204, z: 0};


document.addEventListener("DOMContentLoaded", function(){
    var markers_url="get_markers.php";
    var rotation_url="get_rotation.php";

    function get_rotations (rotations) {
	roomCount = rotations.length;
	for(var index=0; index<roomCount; index++) {
	    var rotationValue = {};
	    var roomKey = "r"; 
	    rotationValue.x = rotations[index].INT_rotation_x;
	    rotationValue.y = rotations[index].INT_rotation_y;
	    rotationValue.z = rotations[index].INT_rotation_z;
	    roomKey+= index;
	    roomOrder[rotations[index].INT_chambre_ID] = roomKey;
	    // console.log(roomKey);
	    // console.log(rotationValue.x + " " + rotationValue.y + " " + rotationValue.z);
	    rotationList[roomKey] = {x: rotationValue.x, y: rotationValue.y, z: rotationValue.z};
	}
	//console.log(roomOrder);
	// console.log(rotationList);
	// console.log(rotations);

    }
    
    function get_markers (markers) {
        // console.log(markers);
	roomCount = markers.length;
	console.log(roomOrder);
	for(var index=0; index<roomCount; index++) {
	    var positionValue = {};
	    var markerKey = roomOrder[markers[index].INT_chambre_ID] + "_" + roomOrder[markers[index].INT_destination_ID];
	    
	    positionValue.x = markers[index].INT_position_x;
	    positionValue.y = markers[index].INT_position_y;
	    positionValue.z = markers[index].INT_position_z;

	    markerList[markerKey] = {x:positionValue.x,y:positionValue.y,z: positionValue.z};
	}
	
    }

    
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    function callAjax(url, callback){
	// compatible with IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp.onreadystatechange = function(){
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
		callback(JSON.parse(xmlhttp.responseText));
		// callback(xmlhttp.responseText);
            }
	}
	xmlhttp.open("POST", url, true);
	xmlhttp.send();
    }

    callAjax(rotation_url, get_rotations);   
    callAjax(markers_url, get_markers);
    
    
});

// document.addEventListener("DOMContentLoaded", function(event) {
//     if (flag === true) {
// 	document.querySelector('a-scene').addEventListener('click', stopShowcase);
// 	console.log("added");
//     } else {
// 	document.querySelector('a-scene').removeEventListener('click', stopShowcase);
// 	console.log("removed");
//     }
// });









var skyEl, skyElSrc, sceneEl;



// place marker based on loaded photo
AFRAME.registerComponent('do-something-once-loaded', {
    init: function () {	
	sceneEl = this.el;
	skyEl = document.querySelector('a-sky');
	skyElSrc = skyEl.getAttribute('src');

	// console.log(rotationList[skyElSrc.split("#")[1]]);
	document.querySelector('#camera').setAttribute('rotation', rotationList[skyElSrc.split("#")[1]]);
	
	var camAnimEl = document.querySelector("#camAnim");

	camAnimEl.emit("showcase");
	
	
	//console.log(markerList);
	for (var place in markerList) {
	    var markerEl = document.createElement('a-sphere');
	    markerEl.setAttribute('color', 'yellow');
	    markerEl.setAttribute('radius', '3');
	    markerEl.setAttribute('transparent', 'true');	
	    markerEl.setAttribute('material', 'opacity', '0.5');
	    markerEl.setAttribute('position', markerList[place]);
	    markerEl.setAttribute('class', place);
	    markerEl.setAttribute('change-room', 'event', 'click');
	    
	    if (!skyElSrc.localeCompare("#"+place.split("_")[0])) {
		sceneEl.appendChild(markerEl);
	    }
	    else {
		if (document.getElementsByClassName(place).length > 0) {
	    	    sceneEl.removeChild(document.getElementsByClassName(place)[0]);
		}
	    }
	}
	// document.querySelector('a-scene').addEventListener('mouseleave', function () {
	//     var rotation = document.querySelector('#camera').getAttribute('rotation');
	//     console.log(rotation.x);
	//     camAnimEl.setAttribute("from", rotation.x + " " + rotation.y + " " + rotation.z);
	//     camAnimEl.emit("showcase");
	//     console.log("out");
	    
	// });
	setTimeout(function () {
	    // console.log("added");
	    document.querySelector('a-scene').addEventListener('mousedown', stopShowcase);
	},100);

    }
});


// // Change room
AFRAME.registerComponent('change-room', {
    schema: {
	event: {type: 'string'},
    },
    init:function() {
	
	var el = this.el;
	if (this.data.event){
	    el.addEventListener(this.data.event, function (evt) {
		var nav = el.getAttribute('class');
		var navTo = nav.split("_")[1];
		
	
		skyEl.setAttribute('src','#'+navTo);
		sceneEl.removeAttribute('do-something-once-loaded');
		sceneEl.setAttribute('do-something-once-loaded','');
		
	
	    });
	}
    }
});
