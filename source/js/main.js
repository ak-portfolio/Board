$(function(){
  $('.limit').on('change', function(){
  var $this = $(this);
  var $option = $this.find('option:selected');
  $('.label').text($option.text());
  // onchange後にフォーカスしてるのが嫌な場合
  $this.blur();
});
});