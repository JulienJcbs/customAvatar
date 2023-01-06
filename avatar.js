const morceaux = { 'color': 0, 'bouche': 1, 'yeux': 2 };

const btnColor = selectElementById('color');
const btnBouche = selectElementById('bouche');
const btnYeux = selectElementById('yeux');

const inColor = selectElementById('inColor');
const inBouche = selectElementById('inBouche');
const inYeux = selectElementById('inYeux');

class Avatar {
    constructor() {
        this.color = new Morceaux('color', 1, 3);
        this.bouche = new Morceaux('bouche', 1, 3);
        this.yeux = new Morceaux('yeux', 1, 3);
    }
    display() {
        selectElementById('color').src = 'src/color-' + this.color.position + '.png';
        selectElementById('bouche').src = 'src/bouche-' + this.bouche.position + '.png';
        selectElementById('yeux').src = 'src/yeux-' + this.yeux.position + '.png';
        inColor.value = this.color.position;
        inBouche.value = this.bouche.position;
        inYeux.value = this.yeux.position;
    }
    nextColor() {
        this.color.next();
        this.display();
    }
    nextBouche() {
        this.bouche.next();
        this.display();
    }
    nextYeux() {
        this.yeux.next();
        this.display();
    }
}

class Morceaux {
    constructor(nom, position, nbMax) {
        this.nom = nom;
        this.position = position;
        this.nbMax = nbMax;
    }
    next() {
        ++this.position;
        if (this.position > this.nbMax) {
            this.position = 1;
        }
    }
}

function selectElementById(id) {
    return document.getElementById(id);
}

var avatar = new Avatar();