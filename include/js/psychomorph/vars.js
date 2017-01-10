// From the Google Closure Library Style Guide

//functionNamesLikeThis;
//variableNamesLikeThis;
//$jQueryObjectNamesLikeThis;
//ConstructorNamesLikeThis;
//EnumNamesLikeThis;
//methodNamesLikeThis;
//SYMBOLIC_CONSTANTS_LIKE_THIS;

//====================================
// !GLOBAL VARIABLES
//====================================

var $finder = $('#finder');
var $imagebox = $('#imagebox');
var $queue = $('#queue');
var $queue_n = $('#queue_n');
var $delin = $('#delin');

var WM = {
    user: {
        id: null,
        accountSize: 0
    },
    finder: null,
    queue: null,
    appWindow : 'login',
    noOnBeforeUnload : false,
    showThumbs: false,
    project: {
        id: null,
        perm: 'read-only'
    },
    blankBG : "url(/include/images/blankface.php)",
    blankImg : "/include/images/blankface.php",
    loadImg: "/include/images/loaders/circle.svg",

    delinContext: $('#template').get(0).getContext('2d'),
    originalHeight : 400,
    originalWidth : 300,
    hashfile: "",
    faceimg: "",
    timer: null,
    showTem: true,
    delinfunc: 'move',
    symPts: [],
    fitPoints: [0, 1, 96],
    delin: {
        temId: 0,
        tem: [],
        lines: [],
        lineColors: [],
        lineWidths: []
    },
    temRatio: 1,
    pts: [],
    eyeClicks : [],
    selectedPts : [],
    current: {
        tem: [],
        lines: []
    },
    undo: {
        tem: [],
        lines: [],
        level: 0
    },
    pasteBoard: [],
    selectedFile: 0,
    pageEvents: {
        mousebutton: {},
        key: {}
    }
};

var KEYCODE = {
    'backspace' : 8,
    'tab' : 9,
    'enter' : 13,
    'shift' : 16,
    'ctrl' : 17,
    'cmd' : 224,
    'alt' : 18,
    'pause_break' : 19,
    'caps_lock' : 20,
    'esc' : 27,
    'page_up' : 33,
    'page_down' : 34,
    'end' : 35,
    'home' : 36,
    'left_arrow' : 37,
    'up_arrow' : 38,
    'right_arrow' : 39,
    'down_arrow' : 40,
    'insert' : 45,
    'delete' : 46,
    '0' : 48,
    '1' : 49,
    '2' : 50,
    '3' : 51,
    '4' : 52,
    '5' : 53,
    '6' : 54,
    '7' : 55,
    '8' : 56,
    '9' : 57,
    'equal' : 61,
    'plus' : 61,
    'minus' : 173,
    'underscore' : 173,
    'a' : 65,
    'b' : 66,
    'c' : 67,
    'd' : 68,
    'e' : 69,
    'f' : 70,
    'g' : 71,
    'h' : 72,
    'i' : 73,
    'j' : 74,
    'k' : 75,
    'l' : 76,
    'm' : 77,
    'n' : 78,
    'o' : 79,
    'p' : 80,
    'q' : 81,
    'r' : 82,
    's' : 83,
    't' : 84,
    'u' : 85,
    'v' : 86,
    'w' : 87,
    'x' : 88,
    'y' : 89,
    'z' : 90,
    'left_window' : 91,
    'right_window' : 92,
    'select_key' : 93,
    '0n' : 96,
    '1n' : 97,
    '2n' : 98,
    '3n' : 99,
    '4n' : 100,
    '5n' : 101,
    '6n' : 102,
    '7n' : 103,
    '8n' : 104,
    '9n' : 105,
    'multiply' : 106,
    'add' : 107,
    'subtract' : 109,
    'decimal_point' : 110,
    'divide' : 111,
    'f1' : 112,
    'f2' : 113,
    'f3' : 114,
    'f4' : 115,
    'f5' : 116,
    'f6' : 117,
    'f7' : 118,
    'f8' : 119,
    'f9' : 120,
    'f10' : 121,
    'f11' : 122,
    'f12' : 123,
    'num_lock' : 144,
    'scroll_lock' : 145,
    'semicolon' : 186,
    'equal_sign' : 187,
    'comma' : 188,
    'dash' : 189,
    'period' : 190,
    'forward_slash' : 191,
    'grave_accent' : 192,
    'open_bracket' : 219,
    'backslash' : 220,
    'closebracket' : 221,
    'single_quote' : 222
};