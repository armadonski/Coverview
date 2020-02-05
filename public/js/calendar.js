const DATE_FORMAT = 'DD-MM-YYYY';
const setWeekDates = (startOfWeek, endOfWeek) => {
    let i;
    const selectedWeekDays = [];
    for (i = startOfWeek; i <= endOfWeek; i++) {
        selectedWeekDays.push(moment().day(i).format(DATE_FORMAT));
    }
    return selectedWeekDays;
};
const setMonthDates = (selectedMonth) => {
    let i;
    const selectedMonthDays = [];
    const daysInMonth = moment().month(selectedMonth).daysInMonth();

    for (i = 1; i <= daysInMonth; i++) {
        selectedMonthDays.push(moment().month(selectedMonth).date(i).format(DATE_FORMAT));
    }
    return selectedMonthDays;
};
const setYearDates = (year) => {
    let i;
    const selectedYearDates = [];
    for (let i = 0; i < 366; i++) {
        selectedYearDates.push(moment().year(year).dayOfYear(i).format(DATE_FORMAT));
    }
    return selectedYearDates;
};

const readAllEventsRoute = "{{ path('read_all_calendar_events')|escape('js') }}";
const readEventByIdRoute = "{{ path('read_calendar_event_by_id', {calendarEventId: '1'})|escape('js') }}";
const readAllUsersRoute = "{{ path('read_all_users')|escape('js') }}";
const createRoute = "{{ path('create_event')|escape('js') }}";
const updateRoute = "{{ path('update_calendar_event_by_id',{calendarEventId: 1})|escape('js') }}";

const getPopOverAjaxCall = () => {
    return $.ajax({
        url: viewPopoverRoute,
        type: 'GET',
        cache: false,
    });
};

let getAllDataAjaxCall = () => {
    return $.ajax({
        url: readAllEventsRoute,
        type: 'GET',
        cache: false,
    });
};

const getUserDataAjaxCall = () => {
    return $.ajax({
        url: readAllUsersRoute,
        type: 'GET',
        cache: false,
    });
};

const postDataAjaxCall = () => {
    return $.ajax({
        url: readAllUsersRoute,
        type: 'GET',
        cache: false,
    });
};

const createAjaxCall = (data) => {
    return $.ajax({
        url: createRoute,
        dataType: 'json',
        type: 'post',
        contentType: 'application/json',
        data: data,
        processData: false,
        success: function (data, textStatus, jQxhr) {
            $('#response pre').html(JSON.stringify(data));
        },
        error: function (jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });

};

const updateAjaxCall = (data) => {
    return $.ajax({
        url: updateRoute + `/${data}`,
        dataType: 'json',
        type: 'put',
        contentType: 'application/json',
        processData: false,
        success: function (data, textStatus, jQxhr) {
            $('#response pre').html(JSON.stringify(data));
        },
        error: function (jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });

};
const loadGrid = () => {
    $.when(getAllDataAjaxCall(), getUserDataAjaxCall()).done((data, userDataAjaxCall) => {
        $(function () {
            $('[data-toggle="popover"]').popover()
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        data = data[0];
        const users = userDataAjaxCall[0];
        let dates = setWeekDates(0, 6);
        const dateObjects = dates.map(date => {
            return {
                name: date,
                type: "text",
                width: 150,
            }

        });
        const userData = users.map(item => {
            return {"Users": item.fullName, id: item.id}
        });

        dates.map((date) => {
            data.map((entry) => {
                userData.map((user) => {
                    let entryDate = moment(entry.event_date.date).format('DD-MM-YYYY');
                    if (user.id === entry.userId) {
                        const updateButton = (id) => {
                            return `<ul><li><a href="#"  id =${id} class="update">Work from home</a></li>
<li><a  href="#" class="update" id =${id}>Concediu</a></li>
<li><a href="#" class="update" id =${id}>Training</a></li>
<li><a href="#" class="update" id =${id}>Suport</a></li></ul>`
                        };
                        user[entryDate] = `<a class="btn btn-primary" href="#" data-toggle='popover' data-trigger='focus' title='Popover title' data-content='${updateButton(entry.id)}' data-html='true' style='width: 100%;height: 100%'>${entry.event_type}</a>`;
                    } else {
                        const createButton = (id, userId) => {
                            return `<ul><li><a href="#"  id =${id}/${userId} class="create">Work from home</a></li>
<li><a  href="#" class="create" id =${id}/${userId}>Concediu</a></li>
<li><a href="#" class="create" id =${id}/${userId}>Training</a></li>
<li><a href="#" class="create" id =${id}/${userId}>Suport</a></li></ul>`
                        };
                        user[date] = `<a class="btn btn-light" href="#" data-toggle='popover' data-trigger='focus' title='Select Event Type' data-content='${createButton(date, user.id)}' data-html='true'  style='width: 100%;height: 100%'>New</a>`;
                    }
                })
            });
        });
        const gridProperties = {
            width: "100%",
            height: "750px",
            inserting: false,
            editing: false,
            sorting: false,
            paging: false,
            selecting: true,
            data: userData,
            fields: [{name: "Users", type: "text", width: 200, editing: false},]
        };
        dateObjects.forEach(dateObject => {
            gridProperties.fields.push(dateObject)
        });
        $("#jsGrid").jsGrid(gridProperties);
    })
}
loadGrid();
$(document).on('click', '.create', function (e) {
    loadGrid();
    const data = (e.target.id.split("/"));
    createAjaxCall(JSON.stringify({
        userId: data[1],
        eventDate: data[0],
        eventType: e.target.innerText
    }));
});

$(document).on('click', '.update', function (e) {
    const id = e.target.id
    loadGrid();
    console.log(id)
    updateAjaxCall(id);
});