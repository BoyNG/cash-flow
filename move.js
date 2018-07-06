$(document).ready(function(){
        var coordX;
        var widthD = $(document).width();
        var move;
        var move1=0;
        var backMove;
        var back =$('.title2');
        var backMoveLast = 0;
        $('body').mousemove(function(e){
            coordX = e.pageX;
            move = coordX;
            if (move1 == 0) {
                backMove = 0;
            }
            else {
                backMove = (move-move1)*100/widthD;
            }
            move1 = move;
            backMoveLast = backMoveLast - backMove;
      /* console.log(backMoveLast);*/
            back.css({'background-position': backMoveLast+'px' })
        })
})
