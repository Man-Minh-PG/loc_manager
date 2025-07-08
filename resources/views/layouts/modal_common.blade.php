   <!-- Extra Large Modal -->
   <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-xl" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel4">Modal title</h5>
                   <button
                       type="button"
                       class="btn-close"
                       data-bs-dismiss="modal"
                       aria-label="Close"></button>
               </div>
               <div class="modal-body">

                   <!-- Section: Get Info -->
                   <div class="mb-3">
                       <h6 class="fw-bold">Get Info</h6>
                       <ul id="getInfoList" class="list-unstyled mb-0">
                           <!-- Will be populated dynamically -->
                       </ul>
                   </div>

                   <!-- Section: Bảng dữ liệu chi tiết -->
                   <div class="table-responsive">
                       <table class="table table-bordered align-middle">
                           <thead class="table-light">
                               <tr>
                                   <th>Status</th>
                                   <th>File Change</th>
                                   <th>PHP</th>
                                   <th>Total</th>
                                   <th>Notes</th>
                                   <th>Run Time</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody id="detailDataTable">
                             
                           </tbody>

                       </table>
                   </div>
               </div>


               <div class="modal-footer">
                   <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                       Close
                   </button>
                   <button type="button" class="btn btn-primary">Save changes</button>
               </div>
           </div>
       </div>
   </div>