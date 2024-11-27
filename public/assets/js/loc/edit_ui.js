$(document).ready(function() {
    let sttCounter = 2;

    $('#addRowBtn').click(function() {
        var newRow = `
                    <tr>
                        <td>${sttCounter}</td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="#1989273"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="#1989273"></td>
                        <td>
                            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                <option selected="">Status</option>
                                <option value="1">New</option>
                                <option value="2">Inprocess</option>
                                <option value="3">Resolve</option>
                                <option value="4">Done</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="11"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="97"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="67"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="32"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="32"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="132"></td>
                        <td>
                            <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" placeholder="Comments here..."></textarea>
                        </td>
                    </tr>
                `;
                $('table tbody').append(newRow);
                sttCounter++;
    });
}); 