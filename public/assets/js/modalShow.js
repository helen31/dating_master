/**
 * Created by Alena on 20.04.2017.
 */
function ModalShow(jElem) {
    this.jElem;

    this.init(jElem);
}

ModalShow.prototype.init = function(jElem) {
    //console.log(jElem);
    this.jElem = jElem;
    this.components = this.jElem.find('.js-img-photo');
    this.modal = this.jElem.find('.js-gla-modal');
    this.modalImg = this.jElem.find('.js-modal-img');

    this.components.on('click', this.showSrc.bind(this));
    this.jElem.find('.js-gla-close').on('click', this.closeModalWindow.bind(this));
};

ModalShow.prototype.showSrc = function (event) {
    var currentSrc;
    currentSrc = $(event.target).attr('src');

    this.showModalWindow(currentSrc);
};

ModalShow.prototype.showModalWindow = function (currentSrc) {
    var src;
    src = currentSrc;

    console.log(currentSrc);
    this.modalImg.attr('src', src);
    this.modal.show();
};

ModalShow.prototype.closeModalWindow = function () {
    this.modal.hide();
};