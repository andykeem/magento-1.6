
var history = {
    
    revert: function(attrCode, value){
        
        $j('input[id=' + attrCode + ']').val(value);
    }
};
