import moment from 'moment'

export default {
    install(app, options) {
        app.config.globalProperties.$formatBytes = (bytes, decimals=2) => {
                if (!+bytes) return '0 Bytes'

                const k = 1024
                const dm = decimals < 0 ? 0 : decimals
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

                const i = Math.floor(Math.log(bytes) / Math.log(k))

                return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
            },
            app.config.globalProperties.$moment = moment,
            app.config.globalProperties.$baseUrl = () => {
                return baseUrl;
            },
            app.config.globalProperties.$assetUrl = () => {
                return assetUrl;
            },
            app.config.globalProperties.$noNullable = (text) => {
                if (text) {
                    return text;
                }
                return '-';
            },
            app.config.globalProperties.$rupiahFormat = (text) => {
                if (!text) {
                    return '0';
                }
                return new Intl.NumberFormat("id-ID", {
                    maximumFractionDigits: 5
                }).format(text);
            },
            app.config.globalProperties.$axiosHandleError = (error, callback = null) => {
                const provide = app._context.provides;
                let res = error.response ? error.response.data.status : null;
                let code = error.response ? error.response.status : null;

                if (code == 400) {
                    provide.$swal({
                        title: "Oopss...",
                        icon: "error",
                        text: res ? res.message : 'Terjadi kesalahan server',
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ok",
                    }).then((result) => {
                        if (callback) {
                            callback;
                        }
                    });
                } else if (code == 403) {
                    localStorage.clear();
                    window.location.replace(baseUrl + '/login');
                } else if (code == 401) {
                    localStorage.clear();
                    window.location.replace(baseUrl + '/login');
                } else if (code == 422) {
                    provide.$swal({
                        title: "Oopss...",
                        icon: "error",
                        text: res ? res.message : 'Terjadi kesalahan server',
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ok",
                    }).then((result) => {
                        if (callback) {
                            callback;
                        }
                    });
                } else if (code == 404) {
                    provide.$swal({
                        title: "Oopss...",
                        icon: "error",
                        text: "Request/Resource not found!",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ok",
                    }).then((result) => {
                        if (callback) {
                            callback;
                        }
                    });
                } else {
                    provide.$swal({
                        title: "Oopss...",
                        icon: "error",
                        text: "Terjadi kesalahan koneksi",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ok",
                    }).then((result) => {
                        if (callback) {
                            callback;
                        }
                    });
                }


            },
            app.config.globalProperties.$ewpLoadingShow = () => {
                var loadingDiv = document.createElement('div')

                loadingDiv.className = 'ewp-loading'

                $('body').append(loadingDiv);
            },
            app.config.globalProperties.$ewpLoadingHide = (error) => {
                $('.ewp-loading').hide();
            }
    }
};
