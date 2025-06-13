<template>
    <div class="pu_site_page">
        <app-header></app-header>

        <section class="main-banner-v2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <img :src="`${$assetUrl()}siapppak/images/poster/konsul2.png`" class="main-header-rounded" style="border-radius: 30px;">
                        <h3 class="main-title-v2 title-float-shadow"></h3>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-3" style="background:#E9E9E9;">
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="konsul-box-rounded mb-4">
                            <div class="row">
                                <div class="col-5">
                                    <a href="">
                                        <img :src="`${$assetUrl()}siapppak/imageskonselor/agung.jpeg`" alt="Agung"
                                            style="border-radius: 50%; width:100%; height:150px;">
                                    </a>
                                </div>
                                <div class="col-7" style="min-height: 100px;">
                                    <p class="name">Adinda Istiqomah, S.Psi., M.Psi., Psikolog</p>
                                    <p class="name" style="font-size: 16px;line-height: 18px;font-weight: 600;">
                                        <a href="">
                                            Senin - Jumat
                                            <br>
                                            08.00 - 16.00
                                        </a>
                                    </p>
                                    <p class="name"><a href=""></a></p>
                                    <p class="position"
                                        style="font-size: 16px;color:#000;font-weight: 600;margin-bottom: 10px;">
                                        Konselor
                                        Psikologi</p>
                                    <a href="#" class="btn-small-red" onclick="openModal('myModal1')">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="konsul-box-rounded mb-4">
                            <div class="row">
                                <div class="col-5">
                                    <a href="">
                                        <img src="" alt="Konselor dua"
                                            style="border-radius: 50%; width:100%; height:150px;">
                                    </a>
                                </div>
                                <div class="col-7" style="min-height: 100px;">
                                    <p class="name">Agung Yuono, S.Psi</p>
                                    <p class="name" style="font-size: 16px;line-height: 18px;font-weight: 600;">
                                        <a href="">
                                            Senin - Jumat
                                            <br>
                                            08.00 - 16.00
                                        </a>
                                    </p>
                                    <p class="name"><a href=""></a></p>
                                    <p class="position"
                                        style="font-size: 16px;color:#000;font-weight: 600;margin-bottom: 10px;">
                                        Konselor
                                        Psikologi</p>
                                    <a href="#" class="btn-small-red" onclick="openModal('myModal2')">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="konsul-box-rounded mb-4">
                            <div class="row">
                                <div class="col-5">
                                    <a href="">
                                        <img src="" alt="Konselor tiga"
                                            style="border-radius: 50%; width:100%; height:150px;">
                                    </a>
                                </div>
                                <div class="col-7" style="min-height: 100px;">
                                    <p class="name">Denia Martini Machdan, S.Psi., M.Psi., Psikolog</p>
                                    <p class="name" style="font-size: 16px;line-height: 18px;font-weight: 600;">
                                        <a href="">
                                            Senin - Jumat
                                            <br>
                                            08.00 - 16.00
                                        </a>
                                    </p>
                                    <p class="name"><a href=""></a></p>
                                    <p class="position"
                                        style="font-size: 16px;color:#000;font-weight: 600;margin-bottom: 10px;">
                                        KONSELOR
                                        PSIKOLOGI</p>
                                    <a href="#" class="btn-small-red" onclick="openModal('myModal3')">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="konsul-box-rounded mb-4">
                            <div class="row">
                                <div class="col-5">
                                    <a href="">
                                        <img src="" alt="Konselor empat"
                                            style="border-radius: 50%; width:100%; height:150px;">
                                    </a>
                                </div>
                                <div class="col-7" style="min-height: 100px;">
                                    <p class="name">Nebi Agustina, S.Psi</p>
                                    <p class="name" style="font-size: 16px;line-height: 18px;font-weight: 600;">
                                        <a href="">
                                            Senin - Jumat
                                            <br>
                                            08.00 - 16.00
                                        </a>
                                    </p>
                                    <p class="name"><a href=""></a></p>
                                    <p class="position"
                                        style="font-size: 16px;color:#000;font-weight: 600;margin-bottom: 10px;">
                                        KONSELOR
                                        PSIKOLOGI</p>
                                    <a href="#" class="btn-small-red" onclick="openModal('myModal4')">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="konsul-box-rounded mb-4">
                            <div class="row">
                                <div class="col-5">
                                    <a href="">
                                        <img src="" alt="Konselor dua"
                                            style="border-radius: 50%; width:100%; height:150px;">
                                    </a>
                                </div>
                                <div class="col-7" style="min-height: 100px;">
                                    <p class="name">Nurul Fajaria Rahmawati, S.Psi</p>
                                    <p class="name" style="font-size: 16px;line-height: 18px;font-weight: 600;">
                                        <a href="">
                                            Senin - Jumat
                                            <br>
                                            08.00 - 16.00
                                        </a>
                                    </p>
                                    <p class="name"><a href=""></a></p>
                                    <p class="position"
                                        style="font-size: 16px;color:#000;font-weight: 600;margin-bottom: 10px;">
                                        KONSELOR
                                        PSIKOLOGI</p>
                                    <a href="#" class="btn-small-red" onclick="openModal('myModal5')">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="konsul-box-rounded mb-4">
                            <div class="row">
                                <div class="col-5">
                                    <a href="">
                                        <img src="" alt="Konselor tiga"
                                            style="border-radius: 50%; width:100%; height:150px;">
                                    </a>
                                </div>
                                <div class="col-7" style="min-height: 100px;">
                                    <p class="name">Randy Prawita Putra, S.Psi</p>
                                    <p class="name" style="font-size: 16px;line-height: 18px;font-weight: 600;">
                                        <a href="">
                                            Senin - Jumat
                                            <br>
                                            08.00 - 16.00
                                        </a>
                                    </p>
                                    <p class="name"><a href=""></a></p>
                                    <p class="position"
                                        style="font-size: 16px;color:#000;font-weight: 600;margin-bottom: 10px;">
                                        KONSELOR
                                        PSIKOLOGI</p>
                                    <a href="#" class="btn-small-red" onclick="openModal('myModal6')">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="konsul-box-rounded mb-4">
                            <div class="row">
                                <div class="col-5">
                                    <a href="">
                                        <img src="" alt="Konselor empat"
                                            style="border-radius: 50%; width:100%; height:150px;">
                                    </a>
                                </div>
                                <div class="col-7" style="min-height: 100px;">
                                    <p class="name">Ratna Harum Kinanti, S.Psi</p>
                                    <p class="name" style="font-size: 16px;line-height: 18px;font-weight: 600;">
                                        <a href="">
                                            Senin - Jumat
                                            <br>
                                            08.00 - 16.00
                                        </a>
                                    </p>
                                    <p class="name"><a href=""></a></p>
                                    <p class="position"
                                        style="font-size: 16px;color:#000;font-weight: 600;margin-bottom: 10px;">
                                        KONSELOR
                                        PSIKOLOGI</p>
                                    <a href="#" class="btn-small-red" onclick="openModal('myModal7')">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div id="myModal1" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('myModal1')">&times;</span>
                    <iframe
                        src="https://docs.google.com/forms/d/e/1FAIpQLScnC0dl0IxYT0mI-EuWaf6Fupk2kqG7mzvTGAgjEne_oTJ9sA/viewform?embedded=true"
                        frameborder="0" marginheight="0" marginwidth="0" style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>

            <div id="myModal2" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('myModal2')">&times;</span>
                    <iframe
                        src="https://docs.google.com/forms/d/e/1FAIpQLSc-yTxgscbqbjcWSNirC9VB0bo1LoUUqs69UKu8LvXhfe3YmQ/viewform?embedded=true"
                        frameborder="0" marginheight="0" marginwidth="0" style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
            <div id="myModal3" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('myModal1')">&times;</span>
                    <iframe src="" frameborder="0" marginheight="0" marginwidth="0"
                        style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>

            <div id="myModal4" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('myModal2')">&times;</span>
                    <iframe src="" frameborder="0" marginheight="0" marginwidth="0"
                        style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
            <div id="myModal5" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('myModal2')">&times;</span>
                    <iframe src="" frameborder="0" marginheight="0" marginwidth="0"
                        style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
            <div id="myModal6" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('myModal1')">&times;</span>
                    <iframe src="" frameborder="0" marginheight="0" marginwidth="0"
                        style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>

            <div id="myModal7" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('myModal2')">&times;</span>
                    <iframe src="" frameborder="0" marginheight="0" marginwidth="0"
                        style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>

        </section>

        <app-footer></app-footer>

    </div>

    <app-popupsearch></app-popupsearch>
    <app-mobilemenu></app-mobilemenu>
</template>

<script>
export default {
    mounted() {

    }
};
</script>