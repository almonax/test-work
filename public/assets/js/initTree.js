$(document).ready(function () {
    var toMoving = [];
    var convertData = [];
    var treeBuilder = function() {
        return $('#tree1').tree({
            data: convertData,
            autoOpen: false,
            dragAndDrop: true
        });
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // open view on double click
    $('#tree1').bind(
        'tree.dblclick',
        function(event) {
            var goTo = window.location.origin + '/view/' + event.node.id;

            return window.open(goTo, '_blank');
        }
    );

    $('#tree1').bind(
        'tree.move',
        function(event) {
            var id, p_id;

            id = event.move_info.moved_node.id;
            if (typeof event.move_info.target_node.parent.id === 'undefined') {
                p_id = 0;
            } else {
                p_id = event.move_info.target_node.id;
            }

            toMoving.push({
                nodeId: id,
                parentId: p_id
            });

            console.log(toMoving);
            addChange();
        });


    function getFirstLevelTree() {
        $.ajax('/get-first', {
           method: "post",
           data: {lvl: 1},
           success: function(data) {
               responseExtract(data, 0);
               treeBuilder();
           },
           error: function(e) {
               console.error(e);
           }
        });
    }

    //! Init Tree
    getFirstLevelTree();


    // helper method
    $('#actionReload').on('click', function() {
        console.log('reload');
        window.location.reload();
    });

    $('#actionSave').on('click', function() {
        $.ajax('/move-node', {
            type: 'post',
            data: {toMovie: toMoving},
            success: function() {
                console.log('All changes saved');
                alert('All changes saved');
                toMoving = [];
                addChange();
            }
        });
        console.log('saving. send array');
        console.log(toMoving);
    });

    function addChange() {
        var badge = $('#actionSave span');
        var value = (! toMoving.length) ? '' : toMoving.length;
        $(badge).html( value );
    }

    function responseExtract(array, j) {
        for (var i = 0; i < array.length; i++) {
            if (array[i] instanceof Array) {
                branch = responseExtract(array[i], j++);
            } else {
                if (i == 0) {
                    convertData.push({
                        label: array[i].fullname,
                        id: array[i].id,
                        children: []
                    });
                } else {
                    convertData[j].children.push({
                        label: array[i].fullname,
                        id: array[i].id,
                        branch: array[i].is_branch
                    });
                    if (array[i].is_branch) {
                        convertData[j].children[convertData[j].children.length - 1].load_on_demand = true
                    }
                }
            }
        }
    }


});