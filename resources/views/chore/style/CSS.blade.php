<style>
.main-div{
    height:500px;
    width: 100%;
    /* background: burlywood; */
}
.div-slider{
    height:210px !important;
    width: 200px !important;
}
.top-div{
    height: 100px;
    margin: 5%;
    padding: 31px;
    font-size: 19px;
}
.btn-post{
   padding: 20px 171px;
    background: white;
    color: green;
    font-size: 20px;
    font-weight: 800;
     border: 2px solid green;
}
.badge {
    display: inline-block;
    padding: .25em .4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}


.badge-primary {
    color: #fff;
    background-color: #007bff;
}
.badge-success {
    color: #fff;
    background-color: #28a745;
}
.badge-danger {
    color: #fff;
    background-color: #dc3545;
}
.badge-warning {
    color: #212529;
    background-color: #ffc107;
}
.badge-secondary {
    color: #fff;
    background-color: #6c757d;
}
.post{
    display: block;
    margin-left: 10%;
    margin-right: 10%;
    padding: 18px;
}
.sliderm{
       margin: 1% 5% 3% 0;
}




.carousel {
  position: relative;
   float: left;
    padding: 4px;
     margin: 0px 0px 0px 15%;
     background: rgb(192, 255, 173);
    border-radius: 5%;
}

.carousel-inner {
  position: relative;
  width: 100%;
  overflow: hidden;
}

.carousel-item {
  position: relative;
  display: none;
  align-items: center;
  width: 100%;
  backface-visibility: hidden;
  perspective: 1000px;
}

.carousel-item.active,
.carousel-item-next,
.carousel-item-prev {
  display: block;
 
}

.carousel-item-next,
.carousel-item-prev {
  position: absolute;
  top: 0;
}

.carousel-item-next.carousel-item-left,
.carousel-item-prev.carousel-item-right {
  transform: translateX(0);

  @supports (transform-style: preserve-3d) {
    transform: translate3d(0, 0, 0);
  }
}

.carousel-item-next,
.active.carousel-item-right {
  transform: translateX(100%);

  @supports (transform-style: preserve-3d) {
    transform: translate3d(100%, 0, 0);
  }
}

.carousel-item-prev,
.active.carousel-item-left {
  transform: translateX(-100%);

  @supports (transform-style: preserve-3d) {
    transform: translate3d(-100%, 0, 0);
  }
}


//
// Alternate transitions
//

.carousel-fade {
  .carousel-item {
    opacity: 0;
    transition-duration: .6s;
    transition-property: opacity;
  }

  .carousel-item.active,
  .carousel-item-next.carousel-item-left,
  .carousel-item-prev.carousel-item-right {
    opacity: 1;
  }

  .active.carousel-item-left,
  .active.carousel-item-right {
    opacity: 0;
  }

  .carousel-item-next,
  .carousel-item-prev,
  .carousel-item.active,
  .active.carousel-item-left,
  .active.carousel-item-prev {
    transform: translateX(0);

    @supports (transform-style: preserve-3d) {
      transform: translate3d(0, 0, 0);
    }
  }
}



.category{
   
    padding: 10px;
    font-weight: 800;
    height: 150px;
    font-size: 20px;
   

}

.c_name{
    
    font-size: 18px;
    font-weight: bolder;

}
.c_price{
    font-weight: 800;
    font-size: 15px;
}
.category ul li{
    padding: 5px;
    /* float: left; */
}
.chore{
    margin: 20px 2% 2% 2%;
    padding: 5px;
    height: 100%;
   
}
.sliderm img{
    height: 153px;
    width: 198px;
    background: green;
    border-radius: 3%;
    border:1px solid green;
     opacity: 1 !important;
}
.chore-div{
    display: inline-block;
    background: rgb(219, 255, 209);
    padding: 4px;
    box-shadow: 1px 1px rgb(124, 249, 104);
    margin: 20px;
    border-radius: 4%;
    opacity: 1 !important;
}

.chore-img{
    height: 165px;
    width: 160px;
    margin: 0px 0px -13px 1px;
    align-items: center;
    border-radius: 4%;
     opacity: 1 !important;

}
.price{
   
    font-size: 15px;
    font-weight: 600;
   
    padding: 5px;
    margin: 4px 4px 3px 69px;

}
.proposal{
  display: block;
    border: 1px solid green;
    margin: 4px;
    height: 100px;
    border-radius: 2%;
    padding: 7px;
}
.proposal div {
  height: 45px;
  float: left;
}
.proposal h6{
  float: left;
  margin-right: 10px;
  font-size:13px;
}
.proposal-des{
 
  height: 100px;
  overflow: hidden;
  float: left;
}
.proposal-des:hover{
  height: 100%;
  float: left;

}
.proposal-pri{
  height: 70px;
  float: left;
}
.alink{
  position: relative;
    
    left: 200%;
    bottom: 10px;
    border-radius: 9%;
    color: white !important;
    font-weight: 900;
    padding:5px;
}
.featured{
   
    position: relative;
    top: -164px;
    left: 127px;
    font-size: 13px;

}
.type {
    position: relative;
    top: 66px;
    left: -91px;
}

.awesome {
    
    font-family: futura;
    font-style: italic;
    
    width:100%;
    
    margin: 0 auto;
    text-align: center;
    font-weight: bold;
    color:#313131;
    /* font-size:45px;
     */
    /* position: absolute; */
    -webkit-animation:colorchange 20s infinite alternate;
    
    
}
.widget-title {
    width: 100%;
    top: 50%;
    background:rgb(49, 198, 3);
    height: 2px;
    left: 0;
    margin-bottom: 30px;
    display: block;
    margin-top: 20px;
    position: relative;
}
.widget-title span {
    text-transform: capitalize;
    padding: 7px 12px;
    border: 2px solid #dedede;
    background: #fefefe;
    position: relative;
    margin: 0 auto;
    top: -7px;
    left: 30px;
    color: #333;
    font-weight: 600;
    font-family: 'Raleway', Arial, Helvetica, sans-serif;
    font-size: 15px;
    border-radius: 4px;
}
.widget-title :hover{
  background: greenyellow;
  padding:20px;
  color:black;
  
}
@-webkit-keyframes colorchange {
    0% {
    
    /* background: #4aefc3; */
    background-image: url("/../chores/1.jpg");
    opacity: .9;
    }
    
    35% {
    background-image: url("/../chores/2.jpg");
    opacity: .9;
    }
    
    70% {
    background-image: url("/../chores/3.jpg");
    opacity: .9;
    }
    
    100% {
    
    background-image: url("/../chores/4.jpg");
    opacity: .9;
    }
    
    
   
}

@media only screen and (max-width: 600px) {
 .top-div {
    height: 8px;
    margin: 47px 1px 171px;
    padding: 4px 5px 4px 5px;
    font-size: 15px;
}
.post {
    /* display: block; */
    margin-left: 2%;
    margin-right: 8%;
    padding: 0px;
    /* float: left; */
}
.btn-post {
    /* padding: 2px 171px; */
    margin: 10px;
    padding: 8px;
    background: white;
    color: green;
    font-size: 20px;
    font-weight: 800;
}
}

</style>