ls
cd protobuf/
ls
protoc --proto_path=. --php_out=. --grpc_out=. --plugin=protoc-gen-grpc=/opt/grpc/bin/grpc_php_plugin ./*.proto
exit
