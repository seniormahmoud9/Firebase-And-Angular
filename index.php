<!DOCTYPE html>
<html ng-app="App">
<head>
	<title>Realtime Application</title>
	<link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container" ng-controller="fireControll"> 
<h3 class="page-header">All Product</h3>
<table class="table">
	<thead>
		<tr>
			<th>Product</th>
			<th>Code</th>
			<th>Description</th>
			<th>Price</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<form>
				<td><input type="text" ng-model="productName" class="form-control" placeholder="Prouct name" /></td>
				<td><input type="text" ng-model="productCode" class="form-control" placeholder="Product code" /></td>
				<td><input type="text" ng-model="description" class="form-control" placeholder="Product description" /></td>
				<td><input type="text" ng-model="price" class="form-control" placeholder="Product price" /></td>
				<td>
					<button class="btn btn-success" ng-click="addProduct()">Add</button>
					<button class="btn btn-warning" ng-click="updateProduct()">Update</button>
				</td>
			</form>			
		</tr>
		<tr ng-repeat="product in products">
			<td>{{ product.productName }}</td>
			<td>{{ product.productCode }}</td>
			<td>{{ product.description }}</td>
			<td>{{ product.price }}</td>
			<td>
				<button class="btn btn-primary" ng-click="editProduct(product)">Edit</button>
				<button class="btn btn-danger" ng-click="deleteProduct(product)">Delete</button>
			</td>
		</tr>
	</tbody>
</table>
</div>
<script type="text/javascript" src="bower_components/angular/angular.js"></script>

<script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>
<!-- AngularFire -->
<script src="https://cdn.firebase.com/libs/angularfire/1.1.3/angularfire.min.js"></script>

<script type="text/javascript">
'use strict';
	var App = angular.module('App',['firebase']);
	App.controller('fireControll',['$scope','$firebaseArray',function($scope, $firebaseArray){

		var myProducts = new Firebase('https://seniorapp.firebaseio.com/products');

		$scope.products = $firebaseArray(myProducts);


		$scope.showForm = function()
		{
			$scope.addFormShow = true;
			$scope.editFormShow = false;
		}	

		$scope.hideForm = function()
		{
			$scope.addFormShow = false;
		}

		function clearForm()
		{
			$scope.productName = "";
			$scope.productCode = "";
			$scope.description = "";
			$scope.price       = "";
		}


		$scope.addProduct = function()
		{
			$scope.products.$add({
				'productName':$scope.productName,
				'productCode':$scope.productCode,
				'description':$scope.description,
				'price':$scope.price
			});
			clearForm();
		}

		$scope.editProduct = function(product) {
			$scope.productName = product.productName;
			$scope.productCode = product.productCode;
			$scope.description = product.description;
			$scope.price       = product.price;
			$scope.id          = product.$id;
			alert($scope.id); 
		}

		$scope.updateProduct = function()
		{
			var id = $scope.id;
			var record = $scope.products.$getRecord(id);	
			record.productName = $scope.productName;	
			record.productCode = $scope.productCode;	
			record.description = $scope.description;	
			record.price       = $scope.price;	
			$scope.products.$save(record);
			clearForm();
		}

		$scope.deleteProduct = function(product){
			$scope.products.$remove(product);
		}

	}]);

</script>
</body>
</html>