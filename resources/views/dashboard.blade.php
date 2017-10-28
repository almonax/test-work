@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">




            <div ui-tree="EmployeesTree" id="tree-root" class="angular-ui-tree">
                <ol ui-tree-nodes="" ng-model="data" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                    <!-- ngRepeat: node in data --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in data" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                        <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                            <!-- ngIf: node.nodes && node.nodes.length > 0 --><a class="btn btn-success btn-xs" ng-if="node.nodes &amp;&amp; node.nodes.length > 0" data-nodrag="" ng-click="toggle(this)"><span class="glyphicon glyphicon-chevron-down" ng-class="{
          'glyphicon-chevron-right': collapsed,
          'glyphicon-chevron-down': !collapsed
        }"></span></a><!-- end ngIf: node.nodes && node.nodes.length > 0 -->
                            node1
                            <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                            <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                        </div>
                        <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                            <!-- ngRepeat: node in node.nodes --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in node.nodes" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                                <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                                    <!-- ngIf: node.nodes && node.nodes.length > 0 --><a class="btn btn-success btn-xs" ng-if="node.nodes &amp;&amp; node.nodes.length > 0" data-nodrag="" ng-click="toggle(this)"><span class="glyphicon glyphicon-chevron-down" ng-class="{
          'glyphicon-chevron-right': collapsed,
          'glyphicon-chevron-down': !collapsed
        }"></span></a><!-- end ngIf: node.nodes && node.nodes.length > 0 -->
                                    node1.1
                                    <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                                </div>
                                <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                                    <!-- ngRepeat: node in node.nodes --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in node.nodes" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                                        <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                                            <!-- ngIf: node.nodes && node.nodes.length > 0 -->
                                            node1.1.1
                                            <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                                            <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                                        </div>
                                        <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                                            <!-- ngRepeat: node in node.nodes -->
                                        </ol>
                                    </li><!-- end ngRepeat: node in node.nodes -->
                                </ol>
                            </li><!-- end ngRepeat: node in node.nodes --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in node.nodes" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                                <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                                    <!-- ngIf: node.nodes && node.nodes.length > 0 -->
                                    node1.2
                                    <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                                </div>
                                <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                                    <!-- ngRepeat: node in node.nodes -->
                                </ol>
                            </li><!-- end ngRepeat: node in node.nodes -->
                        </ol>
                    </li><!-- end ngRepeat: node in data --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in data" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                        <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                            <!-- ngIf: node.nodes && node.nodes.length > 0 --><a class="btn btn-success btn-xs" ng-if="node.nodes &amp;&amp; node.nodes.length > 0" data-nodrag="" ng-click="toggle(this)"><span class="glyphicon glyphicon-chevron-down" ng-class="{
          'glyphicon-chevron-right': collapsed,
          'glyphicon-chevron-down': !collapsed
        }"></span></a><!-- end ngIf: node.nodes && node.nodes.length > 0 -->
                            node2
                            <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                            <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                        </div>
                        <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                            <!-- ngRepeat: node in node.nodes --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in node.nodes" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                                <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                                    <!-- ngIf: node.nodes && node.nodes.length > 0 -->
                                    node2.1
                                    <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                                </div>
                                <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                                    <!-- ngRepeat: node in node.nodes -->
                                </ol>
                            </li><!-- end ngRepeat: node in node.nodes --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in node.nodes" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                                <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                                    <!-- ngIf: node.nodes && node.nodes.length > 0 -->
                                    node2.2
                                    <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                                </div>
                                <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                                    <!-- ngRepeat: node in node.nodes -->
                                </ol>
                            </li><!-- end ngRepeat: node in node.nodes -->
                        </ol>
                    </li><!-- end ngRepeat: node in data --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in data" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                        <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                            <!-- ngIf: node.nodes && node.nodes.length > 0 --><a class="btn btn-success btn-xs" ng-if="node.nodes &amp;&amp; node.nodes.length > 0" data-nodrag="" ng-click="toggle(this)"><span class="glyphicon glyphicon-chevron-down" ng-class="{
          'glyphicon-chevron-right': collapsed,
          'glyphicon-chevron-down': !collapsed
        }"></span></a><!-- end ngIf: node.nodes && node.nodes.length > 0 -->
                            node3
                            <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                            <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                        </div>
                        <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                            <!-- ngRepeat: node in node.nodes --><!-- ngInclude: 'nodes_renderer.html' --><li ng-repeat="node in node.nodes" ui-tree-node="" ng-include="'nodes_renderer.html'" class="angular-ui-tree-node" collapsed="false" expand-on-hover="false">
                                <div ui-tree-handle="" class="tree-node tree-node-content angular-ui-tree-handle">
                                    <!-- ngIf: node.nodes && node.nodes.length > 0 -->
                                    node3.1
                                    <a class="pull-right btn btn-danger btn-xs" data-nodrag="" ng-click="remove(this)"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a class="pull-right btn btn-primary btn-xs" data-nodrag="" ng-click="newSubItem(this)" style="margin-right: 8px;"><span class="glyphicon glyphicon-plus"></span></a>
                                </div>
                                <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="ng-pristine ng-untouched ng-valid angular-ui-tree-nodes">
                                    <!-- ngRepeat: node in node.nodes -->
                                </ol>
                            </li><!-- end ngRepeat: node in node.nodes -->
                        </ol>
                    </li><!-- end ngRepeat: node in data -->
                </ol>
            </div>



            {{--<div ui-tree>--}}
                {{--<ol ui-tree-nodes="" ng-model="list">--}}
                    {{--<li ng-repeat="item in list" ui-tree-node>--}}
                        {{--<div ui-tree-handle>--}}
                            {{--Item title--}}
                        {{--</div>--}}
                        {{--<ol ui-tree-nodes="" ng-model="item.items">--}}
                            {{--<li ng-repeat="subItem in item.items" ui-tree-node>--}}
                                {{--<div ui-tree-handle>--}}
                                    {{--Item title--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--</ol>--}}
                    {{--</li>--}}
                {{--</ol>--}}
            {{--</div>--}}

        </div>
    </div>
</div>

@endsection
