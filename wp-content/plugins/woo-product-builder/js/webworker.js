// 12-07-2020 Không bỏ dòng này!
var hurasoft_webworker = hurasoftWebWorker();


function hurasoftWebWorker() {
    var registered_callbacks = {};
    var hurasoft_web_worker = new Worker("/template/may2020/script/hurasoft_web_worker.js");
    hurasoft_web_worker.onmessage = handleWorkerMessage;
    hurasoft_web_worker.onerror = handleWorkerError;

    return {
        // payload = {type: '', ...}
        // callback = function(worker_data){...}
        send: function (payload, callback) {
            hurasoft_web_worker.postMessage(payload);

            // allow for 1 type to register multiple callbacks
            if(!registered_callbacks.hasOwnProperty(payload.type)){
                registered_callbacks[payload.type] = [];
            }
            registered_callbacks[payload.type].push(callback);
        }
    };

    function handleWorkerMessage(event) {
        var worker_data = event.data;
        var type = (worker_data.hasOwnProperty('type')) ? worker_data['type'] : null;
        if(registered_callbacks.hasOwnProperty(type)){
            registered_callbacks[type].forEach(function (callback) {
                if(typeof callback == 'function') callback(worker_data);
            });
        }
    }

    function handleWorkerError(error) {
        // ...
    }
}
