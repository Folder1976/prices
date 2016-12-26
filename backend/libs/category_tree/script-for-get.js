
$( document ).ready(function() {
    console.log( "ready!" );
    
    //========Открываем-Закрываем дерево
    $("#view_type_tree").click(function(){opencloseTree()});
    
    //==========Закрываем дерево(кнопка в окне)
    $("#treecloase").click(function(){opencloseTree()});
    
    
    //===========Базовый скрипт дерева
    $('#celebTree ul')
      .show()
      .prev('span')
      .before('<span></span>')
      .prev()
      .addClass('handle opened')
      .click(function() {
                  //console.log("open-close1");
        // plus/minus handle click
                 // $(this).toggleClass('closed opened').nextAll('ul').toggle();
      });
    
    $('#celebTree ul')
      .prev('span')
      .children('a')
      .toggleClass('tree tree_ul')
      .click(function() {
                  //console.log("open-close2");
        // plus/minus handle click
                //  $(this).toggleClass('closed opened').nextAll('ul').toggle();
      });
      
    //Развернем первый уровень
    //$("#0").parent('span').parent('li').children('span').first().toggleClass('closed opened').nextAll('ul').toggle();;

});
