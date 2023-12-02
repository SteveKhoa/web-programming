<div>
    <div class="p-5 shadow rounded-3" style="max-height: 1000px">
        <div class="d-flex justify-content-between pb-5">
            <div>
                <h1>Locate our stores</h1>
                <p>Make the purchase at our nearest store.</p>
            </div>
            <div class="w-50">
                <div class="row g-2 d-flex justify-content-end">
                    <!-- The visibility of this part is controlled by javascript -->

                    <div id="fulladdr-container" class="col-auto">
                        <form>
                            <input id="fulladdr-input" type="text" class="rounded-pill form-control" placeholder="Full address">
                        </form>
                    </div>

                    <div id="longlat-container" class="col-auto">
                        <form>
                            <div class="row g-2">
                                <div class="col-auto"><input id="long-input" type="number" class="rounded-pill form-control" placeholder="Longitude"></div>
                                <div class="col-auto"><input id="lat-input" type="number" class="rounded-pill form-control" placeholder="Lattitude"></div>
                            </div>
                        </form>
                    </div>

                    <!-- =============== =================== ==================== -->

                    <div class="col-auto">
                        <button id="search-option-toggle" class="btn btn-outline-success btn rounded-pill" onclick="toggleSearchOption()">
                            <span class="material-icons" style="font-size: 12px;">
                                location_searching
                            </span>
                        </button>
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-outline-primary rounded-pill" onclick="updateMap(this)">
                            <span class="material-icons" style="font-size: 12px;">
                                near_me
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <script>
                /**
                 * 
                 */
                let searchByFullAddr = false;

                const toggleSearchOption = () => {
                    // XOR operation to perform switching
                    searchByFullAddr = false == searchByFullAddr;

                    if (searchByFullAddr) {
                        $("#search-option-toggle").removeClass('active');

                        $("#fulladdr-container").show();
                        $("#longlat-container").hide();
                    } else {
                        $("#search-option-toggle").addClass('active');

                        $("#fulladdr-container").hide();
                        $("#longlat-container").show();
                    }
                }

                toggleSearchOption();
            </script>

            <script>
                const updateMap = (event) => {

                    let q = `10.7770,106.6953`;

                    let fulladdr = $("#fulladdr-input").val();
                    let long = $("#long-input").val();
                    let lat = $("#lat-input").val();
                    
                    if (searchByFullAddr && fulladdr != "") {
                        q = fulladdr;
                    } else if (!isNaN(long) && !isNaN(lat)) {
                        q = `${long},${lat}`;
                    }

                    let url = `https://maps.google.com/maps/?q=${q}&t=&z=15&ie=UTF8&iwloc=&output=embed`;

                    $("#ggmap-frame").prop('src', url);
                }
            </script>
        </div>

        <div class="overflow-scroll">
            <div style="height: 750px;">
                <iframe id="ggmap-frame" style="width: 100%; height:100%" id="gmap_canvas" src="https://maps.google.com/maps/?q=10.7769942,106.6927272&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                </iframe>
            </div>
        </div>
    </div>
</div>