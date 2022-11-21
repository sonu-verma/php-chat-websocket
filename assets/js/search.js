$(function (){
    $(document).on("keyup",'#search',function (){
        const search = $(this).val();
        const userListDiv = $("#recentMessages");
        const resultDiv = $('.result');

        $.post(siteUrl+'core/ajax/search.php',{search:search},function (response){
           if(response){
                userListDiv.hide();
                resultDiv.html(response);
                resultDiv.show();
                if(search === ""){
                    resultDiv.hide();
                    userListDiv.show();
                }
           }
        });
    });
});