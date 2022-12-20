// (function(){
    $(document).on('change',':file',function (event){
        alert('adf');
        const file = this.files[0];
        const sentTo = $('#textarea').data('receiver');

        if(file.size > 2000000){
            alert('max image size is 2mb');
        }

        const formData = new FormData();
        formData.append('file', file)
        formData.append('sentTo', sentTo)

        console.log("formData=>",formData);
        $.ajax({
            url: 'http://localhost/RnD/php-chat-websocket/core/ajax/uploadImage.php',
            type: 'POST',
            data: formData,
            success:function(response){
                console.log("response=>",response);
            },
            cache:false,
            contentType: false,
            processData:false
        });
    });
// });