export const debounce = (fn, delay) => {
    var timeoutID = null;
    return function() {
        clearTimeout(timeoutID);
        var args = arguments;
        var that = this;

        timeoutID = setTimeout(function() {
            fn.apply(that, args);
        }, delay);
    };
};

const toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],

    [{'header': 1}, {'header': 2}],
    [{'list': 'ordered'}, {'list': 'bullet'}],
    [{'script': 'sub'}, {'script': 'super'}],
    [{'indent': '-1'}, {'indent': '+1'}],
    [{'direction': 'rtl'}],

    [{'size': ['small', false, 'large', 'huge']}],
    [{'header': [1, 2, 3, 4, 5, 6, false]}],

    [{'color': []}, {'background': []}],
    [{'font': []}],
    [{'align': []}],
    // ['link', 'image', 'video'],
    ['link'],
    ['clean'],
];

export const editorOptions = {
    modules: {
        toolbar: {
            container: toolbarOptions
        },
        history: {
            delay: 1000,
            maxStack: 50,
            userOnly: false
        }
    }
}

