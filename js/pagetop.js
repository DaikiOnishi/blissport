// JavaScript Document

$(function() {
    var topBtn = $('#page_top');    
    topBtn.hide();
    //�X�N���[����100�ɒB������{�^���\��
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
    //�X�N���[�����ăg�b�v
    topBtn.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});