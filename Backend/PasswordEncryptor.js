const dict = {
        "a": "R",
        "b": "a",
        "c": "H",
        "d": "c",
        "e": "$",
        "f": "A",
        "g": "5",
        "h": "<",
        "i": "=",
        "j": "[",
        "k": "9",
        "l": "f",
        "m": "w",
        "n": "(",
        "o": "?",
        "p": "_",
        "q": ",",
        "r": "r",
        "s": "{",
        "t": "S",
        "u": ";",
        "v": "y",
        "w": "n",
        "x": "!",
        "y": "#",
        "z": "b",
        "A": "7",
        "B": "t",
        "C": "O",
        "D": "p",
        "E": ".",
        "F": "%",
        "G": "U",
        "H": "l",
        "I": "*",
        "J": ":",
        "K": "V",
        "L": "}",
        "M": "J",
        "N": "&",
        "O": "Q",
        "P": "4",
        "Q": "e",
        "R": "q",
        "S": "m",
        "T": "D",
        "U": "`",
        "V": '"',
        "W": "o",
        "X": "h",
        "Y": "Z",
        "Z": "k",
        "0": "I",
        "1": ">",
        "2": "@",
        "3": "|",
        "4": "v",
        "5": "M",
        "6": "1",
        "7": "]",
        "8": "^",
        "9": "j",
        "!": "B",
        '"': "G",
        "#": ")",
        "$": "d",
        "%": "~",
        "&": "W",
        "(": "g",
        ")": "s",
        "*": "C",
        "+": "u",
        ",": "x",
        "-": "+",
        ".": "X",
        "/": "L",
        ":": "8",
        ";": "N",
        "<": "6",
        "=": "F",
        "?": "3",
        "@": "0",
        "[": "E",
        "]": "Y",
        "^": "P",
        "_": "i",
        "`": "z",
        "{": "T",
        "|": "-",
        "}": "/",
        "~": "K",
        "Ñ": "ñ",
        "ñ": "Ñ",
    }

function encrypt(Password) {
    var encrypt_password = ""

    for (const chr of Password) {
        encrypt_password += dict[chr]
    }

    return encrypt_password
}

function decrypt(encrypt_password) {
    var un_password = ""
    
    for (const chr of encrypt_password) {
        un_password += getKeyByValue(dict,chr);
    }

    return un_password

}

function getKeyByValue(obj, value) {
    for (const key in obj) {
        if (obj[key] === value) {
            return key;
        }
    }
    return null;
}

