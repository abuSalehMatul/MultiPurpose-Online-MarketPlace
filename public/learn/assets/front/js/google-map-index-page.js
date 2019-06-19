
function initMap() {
    var html = `
        <div class="goolge-map-content">
                <div class="thumb">
                    <img src="assets/img/news/01.jpg" alt="google hover images">
                    <span class="tag">travel</span>
                    <div class="hover">
                        <span class="rating">3.5</span>
                        <div class="content-inner">
                            <div class="icon">
                                <a href="#"><i class="far fa-heart"></i></a>
                            </div>
                            <div class="content">
                               <a href="#"><h4>Turanto Boat Ride</h4></a>
                                <span class="location">20/b, Parker island, united kingdom</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    `;
    var locations = [
        [html, 23.4748222, 89.2077907, 3, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAABSCAYAAADuK3wcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoyZjM4YjM4OS04NzdiLTRhNDItYjhhOC1kMjk5NmViNjczY2EiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkI5ODk2MkEyNkJBMTFFOEE1NTdBRTg3NDMyOEUxMTgiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RkI5ODk2MjkyNkJBMTFFOEE1NTdBRTg3NDMyOEUxMTgiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NWI3NzVhNTktNDkyYy0yOTQzLWIzODEtMzBkNDk2ZmY2MDBjIiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MDhjYzc2MzAtMGU0Mi0xMWU4LTg5ZDAt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'],
        [html, 23.5048222, 89.9077907, 2, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAABSCAYAAADuK3wcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoyZjM4YjM4OS04NzdiLTRhNDItYjhhOC1kMjk5NmViNjczY2EiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RTEwQ0NFN0UyNkJCMTFFODhERDdBRkFDQjdBRUM1QTkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RTEwQ0NFN0QyNkJCMTFFODhERDdBRkFDQjdBRUM1QTkiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NWI3NzVhNTktNDkyYy0yOTQzLWIzODEtMzBkNDk2ZmY2MDBjIiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MDhjYzc2MzAtMGU0Mi0xMWU4LTg5ZDAt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'],
        [html, 23.6048222, 90.0577907, 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAABSCAYAAADuK3wcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoyZjM4YjM4OS04NzdiLTRhNDItYjhhOC1kMjk5NmViNjczY2EiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RURGMDZEQzkyNkJCMTFFOEJCMkNEMTEzQjUwMkM1M0UiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RURGMDZEQzgyNkJCMTFFOEJCMkNEMTEzQjUwMkM1M0UiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NWI3NzVhNTktNDkyYy0yOTQzLWIzODEtMzBkNDk2ZmY2MDBjIiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MDhjYzc2MzAtMGU0Mi0xMWU4LTg5ZDAt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'],
        [html, 23.4648222, 90.0077907, 4, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAABSCAYAAADuK3wcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoyZjM4YjM4OS04NzdiLTRhNDItYjhhOC1kMjk5NmViNjczY2EiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkFFOTFBMDEyNkJCMTFFOEJBRENFMUI2OEFDODMwNzciIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RkFFOTFBMDAyNkJCMTFFOEJBRENFMUI2OEFDODMwNzciIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NWI3NzVhNTktNDkyYy0yOTQzLWIzODEtMzBkNDk2ZmY2MDBjIiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MDhjYzc2MzAtMGU0Mi0xMWU4LTg5ZDAt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'],
    ];

    var map = new google.maps.Map(document.getElementById('header-map'), {
        zoom: 10,
        center: new google.maps.LatLng(23.8066719, 90.3237784),
        styles: [
            {
                elementType: 'geometry',
                stylers: [{
                    color: '#F7F7F7'
                }]
            },
            {
                featureType: 'administrative.locality',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#444444'
                }]
            },
            {
                featureType: 'poi.park',
                elementType: 'geometry',
                stylers: [{
                    color: '#F7F7F7'
                }]
            },
            {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{
                    color: '#CDC2C2'
                }]
            },
            {
                featureType: 'road',
                elementType: 'geometry.stroke',
                stylers: [{
                    color: '#CDC2C2'
                }]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{
                    color: '#A2A1A1'
                }]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{
                    color: '#A2A1A1'
                }]
            },
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{
                    color: '#C9E5F0'
                }]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#898A89'
                }]
            }
        ]
        //mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: locations[i][4],
            animation: google.maps.Animation.DROP,
        });
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }




}

