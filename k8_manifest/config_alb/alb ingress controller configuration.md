Refer: https://docs.aws.amazon.com/eks/latest/userguide/aws-load-balancer-controller.html

---

eksctl utils associate-iam-oidc-provider --region ap-northeast-1 --cluster simpson-prod --approve

curl -o iam_policy.json https://raw.githubusercontent.com/kubernetes-sigs/aws-load-balancer-controller/v2.2.0/docs/install/iam_policy.json

aws iam create-policy --policy-name SimpsonProdAWSLoadBalancerControllerIAMPolicy --policy-document file://iam_policy.json
==>
{  
 "Policy": {  
 "PolicyName": "SimpsonProdAWSLoadBalancerControllerIAMPolicy",  
 "PolicyId": "ANPA3Q7PX22UJ3V77CXL3",  
 "Arn": "arn:aws:iam::792387376808:policy/SimpsonProdAWSLoadBalancerControllerIAMPolicy",  
 "Path": "/",  
 "DefaultVersionId": "v1",  
 "AttachmentCount": 0,  
 "PermissionsBoundaryUsageCount": 0,  
 "IsAttachable": true,  
 "CreateDate": "2021-06-17T06:05:16+00:00",  
 "UpdateDate": "2021-06-17T06:05:16+00:00"  
 }  
}

eksctl create iamserviceaccount --cluster=simpson-prod --namespace=kube-system --name=aws-load-balancer-controller --attach-policy-arn=arn:aws:iam::792387376808:policy/SimpsonProdAWSLoadBalancerControllerIAMPolicy --override-existing-serviceaccounts --approve

kubectl apply --validate=false -f https://github.com/jetstack/cert-manager/releases/download/v1.1.1/cert-manager.yaml

kubectl apply -f v2_2_0_full.yaml
