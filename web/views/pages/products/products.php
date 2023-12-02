<div class="w-50 mx-auto">
    <div class="p-5 shadow rounded-3" style="max-height: 1000px">
        <div class="pb-5">
            <h1>View Products</h1>
            <p>Your dream market here.</p>
        </div>

        <div class="my-3">
            <div class="input-group mb-3">
                <input type="text" class="form-control" onkeyup="reloadTableView(this.value, filter)" placeholder="Search products by">
                <button id="search-dropdown" class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"></button>
                <ul class=" dropdown-menu">
                    <li><span class="dropdown-item" href="#" onclick="selectSearchOption(this.innerHTML)">ID </span></li>
                    <li><span class="dropdown-item" href="#" onclick="selectSearchOption(this.innerHTML)">Name </span></li>
                    <li><span class="dropdown-item" href="#" onclick="selectSearchOption(this.innerHTML)">Price </span></li>
                </ul>
                <!-- <button class="btn btn-primary" type="button">Search</button> -->
            </div>
            <script>
                const selectSearchOption = (option) => {
                    filter = option;
                    changeDropdownTitle(option);
                }

                const changeDropdownTitle = (title) => {
                    let dropdownButton = document.querySelector("#search-dropdown");
                    dropdownButton.innerHTML = title;
                }

                let filter = "";
                selectSearchOption("ID");
            </script>
        </div>

        <div>
            <div id="table-results">
                <div id="search-setting" class="my-3 p-3 rounded-3 bg-light bg-gradient overflow-scroll" style="max-height: 100px;">
                    <div id="seach-setting-header" class="d-flex justify-content-between">
                        <div class="form-check form-switch">
                            <input id="pagination-checkbox" type="checkbox" class="form-check-input" onclick="togglePagination()">
                            <label class="form-check-label">Allow pagination</label>
                        </div>
                        <div>
                            <h6>Search Settings</h6>
                        </div>
                    </div>
                    <div id="search-setting-body" class="mt-3" style="display: none;">
                        <div>
                            <span>View</span>
                            <input type="number" class="d-inline-block form-control rounded-pill" style="max-width: 64px; max-height: 32px;" step="5" min="5" max="20" value="5" onchange="setChunk(this)">
                            <span class="d-inline-block">results per page</span>
                        </div>
                    </div>
                    <script>
                        /**
                         * Search Setting View controller
                         */
                        let allowPagination = document.querySelector("#pagination-checkbox").checked;
                        let chunkSize = 5; // Default chunk size of table render

                        const togglePagination = () => {
                            // XOR operation on allowPagination,
                            // facilitates toggle operation
                            allowPagination = false == allowPagination;

                            if (allowPagination) {
                                document.querySelector("#search-setting-body").style.display = 'block';
                            } else {
                                document.querySelector("#search-setting-body").style.display = 'none';
                            }
                        }

                        const setChunk = (target) => {
                            chunkSize = target.value;
                        }
                    </script>
                </div>

                <!--The visibility of this part is controlled by Javascript-->
                <span id="result-count" class="text-muted">About 10 results</span>

                <span id="alt-empty-result">No products match your search. Please try again.</span>

                <span id="alt-no-input">Search to start seeing the products.</span>

                <div id="product-table" class="table-responsive" style="max-height: 500px ;" onscroll="onTableScroll(this)">
                </div>

                <nav id="table-pagination-nav">
                    <ul id="pagination-nav-contents" class="pagination justify-content-center">
                        <li id="pg-btn-prev" class="page-item"><span onclick="showPrevious()" class="page-link material-icons">chevron_left</span></li>
                        <li id="pg-btn-1" class="page-item pg-btn active"><span onclick="showMe(this)" class="page-link">1</span></li>
                        <li id="pg-btn-2" class="page-item pg-btn"><span onclick="showMe(this)" class="page-link">2</span></li>
                        <li id="pg-btn-3" class="page-item pg-btn"><span onclick="showMe(this)" class="page-link">3</span></li>
                        <li id="pg-btn-next" class="page-item"><span onclick="showNext()" class="page-link material-icons">chevron_right</span></li>
                    </ul>
                </nav>
                <script>
                    /**
                     * View of pagination-nav
                     */
                    const showPrevious = () => {
                        shiftRangeVisibility(-3);
                    }

                    const showMe = (target) => {
                        let newPage = target.innerHTML;

                        activatePageButton(newPage);
                        currentPage = newPage;

                        paginationRenderPage(currentPage, chunkSize);
                    }

                    const showNext = () => {
                        shiftRangeVisibility(3);
                    }
                </script>

                <script>
                    /**
                     * Controller of pagination-nav
                     */
                    let pageRange = {
                        'fullRange': {
                            'min': 1,
                            'max': 10
                        },
                        'visibleRange': {
                            'min': 1,
                            'max': 3,
                            'displayRange': 3
                        }
                    };

                    let currentPage = pageRange['visibleRange']['min'];


                    /**
                     * Highlight page button-`page` on the pagination-nav
                     */
                    const activatePageButton = (page) => {
                        $("#pagination-nav-contents .pg-btn").removeClass("active");
                        $(`#pg-btn-${page}`).addClass("active");
                    }

                    /**
                     * Change display of page range by n-units
                     */
                    const shiftRangeVisibility = (units) => {
                        let min_visible = pageRange['visibleRange']['min'];
                        let min_limit = pageRange['fullRange']['min'];
                        let max_limit = pageRange['fullRange']['max'];

                        let new_min_visible = min_visible + units;

                        if (new_min_visible < min_limit || new_min_visible > max_limit) {
                            /**
                             * New range is not valid, the function does nothing
                             */
                            return;
                        }

                        pageRange['visibleRange']['min'] = new_min_visible;
                        pageRange['visibleRange']['max'] = new_min_visible + pageRange['visibleRange']['displayRange'] - 1;

                        clearPaginationNav();
                        newPaginationNav(pageRange['visibleRange']['min'], pageRange['visibleRange']['max']);
                        showMe({
                            'innerHTML': pageRange['visibleRange']['min']
                        });
                    }

                    const clearPaginationNav = () => {
                        $("#pagination-nav-contents .pg-btn").remove();
                    }

                    const newPaginationNav = (range_lower_bound, range_upper_bound) => {

                        let pgBtnElements = "";
                        for (let page = range_lower_bound; page <= range_upper_bound; ++page) {
                            let pgBtnElement = `<li id="pg-btn-${page}" class="page-item pg-btn"><span onclick="showMe(this)" class="page-link">${page}</span></li>`;
                            pgBtnElements += pgBtnElement;
                        }
                        $("#pagination-nav-contents #pg-btn-prev").after(pgBtnElements);
                    }
                </script>
            </div>

            <script>
                let lastLoadedIndex = -1;
                let tableContents = "";

                const resetRenderOptions = () => {
                    tableContents = "";
                    lastLoadedIndex = -1;
                }
            </script>
            <script>
                /**
                 * Script to update the table based on pagination
                 */

                const renderAsPagination = (responseObject) => {
                    const head = responseObject['head'];
                    tableContents = responseObject['contents'];

                    let renderedTableHead = "";

                    for (const [_, column_name] of Object.entries(head)) {
                        renderedTableHead += `
                        <th scope="col">${column_name}</th>
                        `;
                    }

                    document.querySelector("#product-table").innerHTML = `
                                <table class="table overflow-scroll">
                                    <thead>
                                        <th scope="col">No.</th>
                                        ${renderedTableHead}
                                    </thead>
                                    <tbody id="product-table-contents"> 
                                    </tbody>
                                </table>
                                `;

                    paginationRenderPage(1, chunkSize);
                }

                const paginationRenderPage = (page, chunkSize = 15) => {
                    let product_table_content = document.querySelector("#product-table-contents");
                    if (product_table_content != null) {
                        product_table_content.innerHTML = "";
                    }
                    let paginationTableContent = "";

                    for ([entryIndex, row] of Object.entries(tableContents)) {
                        let previousCheckpoint = lastLoadedIndex;

                        if (Number(page * chunkSize - chunkSize) <= Number(entryIndex) && Number(entryIndex) < Number(page * chunkSize)) {
                            let newContent = `
                                        <tr>
                                            <td scope="row">${Number(entryIndex) + 1}</th>
                                            <th scope="row">${row['id']}</th>
                                            <td><span class="text-primary" onclick="seeProductDetails('${row['id']}')">${row['product_name']}</span></td>
                                            <td>$${row['price']}</td>
                                        </tr>
                                        `;

                            paginationTableContent += newContent
                        } else {
                            // If the entryIndex does not belong the page, the content will not be displayed.
                            continue;
                        }
                    }

                    document.querySelector("#product-table-contents").innerHTML = paginationTableContent;
                }

                showMe({
                    'innerHTML': currentPage
                });
            </script>
            <script>
                /**
                 * Script to update the table based on lazy loading
                 */
                let lazyChunkSize = 15; // Lazy loading chunk size is fixed

                const renderAsLazy = (responseObject) => {
                    const head = responseObject['head'];
                    tableContents = responseObject['contents'];

                    let renderedTableHead = "";
                    let renderedTableContent = "";

                    for (const [_, column_name] of Object.entries(head)) {
                        renderedTableHead += `
                        <th scope="col">${column_name}</th>
                        `;
                    }

                    document.querySelector("#product-table").innerHTML = `
                                <table class="table overflow-scroll">
                                    <thead>
                                        <th scope="col">No.</th>
                                        ${renderedTableHead}
                                    </thead>
                                    <tbody id="product-table-contents"> 
                                        ${renderedTableContent}
                                    </tbody>
                                </table>
                                `;

                    // Continues loading from the last checkpoint
                    continueLazy(lazyChunkSize);
                }

                const continueLazy = (lazyChunkSize) => {
                    // Requires lastLoadedIndex to continue the previous checkpoint

                    for ([entryIndex, row] of Object.entries(tableContents)) {
                        let previousCheckpoint = lastLoadedIndex;

                        if (Number(entryIndex) <= Number(previousCheckpoint)) {
                            // Dont print the contents if it is already printed
                            continue;
                        }

                        let newContent = `
                                        <tr>
                                            <td scope="row">${Number(entryIndex) + 1}</th>
                                            <th scope="row">${row['id']}</th>
                                            <td><span class="text-primary" onclick="seeProductDetails('${row['id']}')">${row['product_name']}</span></td>
                                            <td>$${row['price']}</td>
                                        </tr>
                                        `;

                        document.querySelector("#product-table-contents").innerHTML += newContent;

                        lastLoadedIndex = entryIndex;

                        if (entryIndex != 0 && entryIndex % lazyChunkSize == 0 && tableContents.length - entryIndex > lazyChunkSize) {
                            break;
                        }
                    }
                }

                const onTableScroll = (event) => {
                    if (!allowPagination && event.offsetHeight + event.scrollTop >= event.scrollHeight) {
                        continueLazy(lazyChunkSize);
                    }
                }
            </script>

            <script>
                /**
                 * Script to manage visibility of the table-results
                 */

                let previous_intput = "";

                const reloadTableView = (input, filter) => {

                    if (input.length == 0) {
                        hideAll();
                        setVisible("#alt-no-input");
                        enableSearchSetting();
                        previous_intput = "";
                        return;
                    } else {
                        const xmlhttp = new XMLHttpRequest();

                        xmlhttp.onreadystatechange = () => {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                /** On receiving AJAX response */
                                // If the input did not change then do not do anything.
                                if (input == previous_intput) return;

                                clearTableContents();
                                resetRenderOptions();
                                previous_intput = input;

                                let responseObject = JSON.parse(xmlhttp.responseText);

                                if (responseObject['contents'].length <= 0) {
                                    hideAll();
                                    setVisible("#alt-empty-result");
                                    disableSearchSetting();
                                    return;
                                }

                                hideAll();
                                setVisible("#result-count");
                                setInnerHTML("#result-count", `About ${responseObject['contents'].length} results`);
                                setVisible("#product-table");
                                disableSearchSetting();

                                if (allowPagination) {
                                    // If pagination is allowed.
                                    setVisible("#table-pagination-nav");
                                    renderAsPagination(responseObject);
                                } else {
                                    // Otherwise, will be lazy loading by default
                                    // Lazy loading needs lastLoadedIndex to know what it had loaded so far.
                                    renderAsLazy(responseObject);
                                }
                            }
                        };

                        let url = "/" + "controllers/form.php?type=query_products&q=" + input;
                        if (filter) {
                            url += "&filter=" + filter;
                        }
                        xmlhttp.open("GET", url, true);
                        xmlhttp.send();
                    }
                    return;
                }

                const setVisible = (selector) => {
                    document.querySelector(selector).style.display = '';
                }

                const hideAll = () => {
                    document.querySelector("#alt-empty-result").style.display = 'none';
                    document.querySelector("#alt-no-input").style.display = 'none';
                    document.querySelector("#product-table").style.display = 'none';
                    document.querySelector("#result-count").style.display = 'none';
                    document.querySelector("#table-pagination-nav").style.display = 'none'
                }

                const setInnerHTML = (selector, html) => {
                    document.querySelector(selector).innerHTML = html;
                }

                const clearTableContents = () => {
                    document.querySelector("#product-table").innerHTML = "";
                    document.querySelector("#result-count").innerHTML = "";
                }

                const disableSearchSetting = () => {
                    $("#search-setting :input").prop('disabled', true);
                }

                const enableSearchSetting = () => {
                    $("#search-setting :input").prop('disabled', false);
                }

                reloadTableView("");
            </script>

            <div id="product-details" class="modal fade">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" data-bs-keyboard="false">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5>Details</h5>
                        </div>
                        <div class="mx-3 modal-body">
                            <div class="mb-5">
                                <div style="display: inline">
                                    <h3 id="product-name" class="text-primary" style="display: inline">Default Produsdasdasdasdct Name</h3>
                                    <span id="product-id" class="ms-2 text-muted">0000</span>
                                </div>
                                <p id="product-brief">This is a very long product description line</p>
                                <p id="product-price" class="text-muted">$125.55</p>
                            </div>
                            <div class="my-3">
                                <h6>A few other information here...</h6>a
                                <p class="text-muted">This is a more detailed infoThis is a more detailed infoThis is a more detailed infoThis is a more detailed infoThis is a more detailed infoThis is a more detailed infoThis is a more detailed infoThis is a more detailed infoThis is a more detailed infoThis is a more detailed infoThis is a more detailed info</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" disabled>Buy Now</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const seeProductDetails = (product_id) => {
                    const prodDetailsRequest = new XMLHttpRequest();

                    prodDetailsRequest.onreadystatechange = () => {
                        if (prodDetailsRequest.readyState == 4 && prodDetailsRequest.status == 200) {
                            let responseDetails = JSON.parse(prodDetailsRequest.responseText)

                            const column_names = [].concat.apply([], responseDetails['column_names']);
                            const contents = responseDetails['contents'][0];

                            document.querySelector("#product-name").innerHTML = `${contents['product_name']}`;
                            document.querySelector("#product-id").innerHTML = `${contents['id']}`;
                            document.querySelector("#product-brief").innerHTML = `The product ${contents['product_name']} is very worthy to buy!`;
                            document.querySelector("#product-price").innerHTML = `$${contents['price']}`;
                        }
                    }

                    let url = "/" + "controllers/form.php?type=details_product&id=" + product_id;
                    prodDetailsRequest.open("GET", url, true);
                    prodDetailsRequest.send();

                    let myModal = new bootstrap.Modal(document.getElementById("product-details"), {
                        keyboard: false
                    }).toggle()
                }
            </script>
        </div>
    </div>
</div>

<!-- This HTML part is only available to ADMIN users.

    Displaying add product card
-->
<?php if (isset($_SESSION['STARTED']) && isset($_SESSION['user_group']) && $_SESSION['user_group'] == 'Admin') { ?>
    <div class="col-2 mx-auto my-5" data-bs-toggle="collapse" data-bs-target="#addProductsCard">
        <button class="btn btn-outline-primary">ADD NEW PRODUCT</button>
    </div>

    <div class="w-50 mx-auto">
        <div id="addProductsCard" class="collapse p-5 shadow rounded-3">
            <div class="pb-5">
                <h4>Add new Products</h4>
                <p>Start selling your items today.</p>
            </div>

            <div>
                <form action="controllers/form.php?type=add_products" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Product ID</label>
                        <input name="product_id" type="text" class="form-control" placeholder="xxxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input name="product_name" type="text" class="form-control" placeholder="ProductABC..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input name="product_price" type="number" step="0.01" class="form-control" placeholder="$$$" required>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="mr-5">
                            <button type="submit" class="col-4 btn btn-primary">INSERT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>