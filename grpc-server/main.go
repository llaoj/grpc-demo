package main

import (
	"log"
	"net"

	"google.golang.org/grpc"

	"grpc-server/protobuf/gen"
	"grpc-server/app"
	"grpc-server/config"
	// "grpc-server/model"
)

func main() {
	config.Setup()
	// model.Setup()

	port := "13481"
	lis, err := net.Listen("tcp", ":"+port)
	if err != nil {
		log.Fatalf("failed to listen: %v", err)
	}
	s := grpc.NewServer()

	gen.RegisterJobServiceServer(s, &app.Job{})

	log.Printf("grpc server in :%v", port)
	s.Serve(lis)
}
