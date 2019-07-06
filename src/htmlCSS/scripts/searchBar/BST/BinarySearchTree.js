class BinaryTreeNode {
		
	constructor(data) {
		//stock name and the stock symbol
		this.data = data;
		
		//right and left nodes
		this.right = null;
		this.left = null;
	}
}

class BinarySearchTree {
	constructor() {
		this.root = null;
	}
	
	
	sortedArrayToBST(arr, start, end) {
		//base case
		if (start > end) {
			return null;
		}
		
		//get the middle element andm ake it root
		var midPoint = Math.floor((start + end) / 2);
				
		var node = new BinaryTreeNode(arr[midPoint]);
		
		//recursively construct left subtree and make it left child of the root
		node.left = this.sortedArrayToBST(arr, start, (midPoint - 1));
		
		//recursively construct right subtree and make it right child of the root
		node.right = this.sortedArrayToBST(arr, (midPoint + 1), end);
		
		return node;
	}
	
	preOrder(node) {
		if (node === null) {
			return;
		}
		
		console.log(node.data + " ");
		this.preOrder(node.left);
		this.preOrder(node.right);
	}
	
	
	findMinNode(node) {
		if (node.left === null) {
			return node;
		}
		else {
			return this.findMinNode(node.left);
		}
	}
	
	getRootNode() {
		return this.root;
	}
	
	search(node, data) {
		if (node === null) {
			return null;
		}
		else if (data < node.data) {
			return this.search(node.left, data);
		}
		else if (data > node.data) {
			return this.search(node.right, data);
		}
		
		else {
			return node;
		}
	}
}


var arr = [1,2,3,4,5,6,7];
n = arr.length;

tree = new BinarySearchTree();

treeRoot = tree.sortedArrayToBST(arr, 0, n - 1);

tree.preOrder(treeRoot);




