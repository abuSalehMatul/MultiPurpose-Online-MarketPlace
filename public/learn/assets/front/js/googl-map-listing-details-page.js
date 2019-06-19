
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
                                <a href='#'><i class="far fa-heart"></i></a>
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
    //listing details map 
    var listingDetailsmap = new google.maps.Map(document.getElementById('listing-details-map'), {
        zoom: 15,
        center: new google.maps.LatLng(23.8741903, 90.3918489),
        styles: [{
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
    var listingDetailsInfowindow = new google.maps.InfoWindow({
        content: html
    });
    var listingMarkup = new google.maps.Marker({
        position: { lat: 23.8741903, lng: 90.3918489 },
        map: listingDetailsmap,
        icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAABSCAYAAADuK3wcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoyZjM4YjM4OS04NzdiLTRhNDItYjhhOC1kMjk5NmViNjczY2EiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkFFOTFBMDEyNkJCMTFFOEJBRENFMUI2OEFDODMwNzciIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RkFFOTFBMDAyNkJCMTFFOEJBRENFMUI2OEFDODMwNzciIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NWI3NzVhNTktNDkyYy0yOTQzLWIzODEtMzBkNDk2ZmY2MDBjIiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MDhjYzc2MzAtMGU0Mi0xMWU4LTg5ZDAt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',
        animation: google.maps.Animation.DROP,
    });
    listingMarkup.addListener('click', function () {
        listingDetailsInfowindow.open(listingDetailsmap, listingMarkup);
    });
    //listing details map indide tab
    var listingDetailsmapInsideTab = new google.maps.Map(document.getElementById('listing-details-map-inside-tab'), {
        zoom: 15,
        center: new google.maps.LatLng(23.8741903, 90.3918489),
        styles: [{
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
    var listingDetailsInfowindowInsideTab = new google.maps.InfoWindow({
        content: html
    });
    var listingMarkupInsideTab = new google.maps.Marker({
        position: {lat:23.8741903, lng:90.3918489},
        map: listingDetailsmapInsideTab,
        icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAABSCAYAAADuK3wcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoyZjM4YjM4OS04NzdiLTRhNDItYjhhOC1kMjk5NmViNjczY2EiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkFFOTFBMDEyNkJCMTFFOEJBRENFMUI2OEFDODMwNzciIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RkFFOTFBMDAyNkJCMTFFOEJBRENFMUI2OEFDODMwNzciIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NWI3NzVhNTktNDkyYy0yOTQzLWIzODEtMzBkNDk2ZmY2MDBjIiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MDhjYzc2MzAtMGU0Mi0xMWU4LTg5ZDAt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',
        animation: google.maps.Animation.DROP,
    });
    listingMarkupInsideTab.addListener('click', function () {
        listingDetailsInfowindowInsideTab.open(listingDetailsmapInsideTab, listingMarkupInsideTab);
    });

}

