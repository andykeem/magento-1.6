
var history = {
    
    revert: function(attrCode, value){
        
        $j(':input[id=' + attrCode + ']').val(value);
    },
    
    dialog: function(conf){

        Dialog.alert(
            { url: conf.url, options: { method: 'get', parameters: conf.params } }, 
            {
                draggable:true,
                resizable:true,
                closable:true,
                className: 'magento',
                windowClassName: 'popup-window',
                title: 'History',
                width: 700,
                minHeight: 500,
                maxHeight: 500,
                zIndex: 1000,
                recenterAuto: false,
                hideEffect: Element.hide,
                showEffect: Element.show,
                id: 'catalog-wysiwyg-editor',
                buttonClass: 'form-button'
            });
    }
};
