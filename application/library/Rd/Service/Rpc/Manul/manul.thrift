namespace php rpc.sms

struct CommonRequest {
 1: required string msgId;
 2: required bool asyncFlag = false;
 3: required string callBackService = "";
 4: required string callBackMethod = "";
 5: required string version = "1.0.0";
 6: required string method;
 7: required string source;
}

struct PostRequest {
  1: string ophone = "",
  2: string iphone = "",
  3: string content = "",
  4: string channel = "",
  5: string delay = "",
}

struct PostResponse {
  1: i32 code = 0,
  2: string msg = "",
  3: string data = "",
}

service ISmsRemoteService {

  PostResponse post(1: CommonRequest p1, 2: PostRequest p2)

}
