/**
 * Created by Sanik on 20.04.2017.
 */
function ModalShow(jElem) {
    this.jElem;

    this.init(jElem);
}

ModalShow.prototype.init = function(jElem) {
    //console.log(jElem);
    this.jElem = jElem;
    this.components = this.jElem.find('.js-img-photo');


    //debugger;
};