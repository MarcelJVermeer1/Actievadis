import Alpine from "alpinejs";
import toastr from "toastr";
import "toastr/build/toastr.min.css";
import "./bootstrap";

toastr.options = {
    closeButton: false,
    progressBar: true,
    newestOnTop: true,
    positionClass: "toast-bottom-right",
    timeOut: "2500", // 2.5 seconds
    extendedTimeOut: "0",
};

window.toastr = toastr;

window.Alpine = Alpine;

Alpine.start();
