/**
 * Function h2bb2h
 * Let there be light !
 */
String.prototype.h2b = function()
{ 
   var i = 0, len = this.length, result = "";
   for(; i < len; i+=2)
      result += '%' + this.substr(i, 2);      
   return unescape(result);
}
String.prototype.b2h = function ()
{
  var i = 0, l = this.length, chr, hex = ''
  for (i; i < l; ++i)
  {
    chr = this.charCodeAt(i).toString(16)
    hex += chr.length < 2 ? '0' + chr : chr
  }
  return hex
}